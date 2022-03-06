<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\CheeseListing;
use App\Entity\User;
use App\Test\CustomApitestCase;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UserResourceTest extends CustomApitestCase
{
    private const PASSWORD_PLAIN_FOO = 'foo';

    use ReloadDatabaseTrait;

    public function testCreateUser()
    {
        $client = self::createClient();

        $email1 = self::getRandomEmail();
        $uname1 = self::getRandomUsername();
        $passw1 = self::PASSWORD_PLAIN_FOO;

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => $email1,
                'username' => $uname1,
                'password' => $passw1
            ]
        ]);

        self::assertResponseStatusCodeSame(201);
        $this->login($client, $email1, $passw1);
        self::assertResponseStatusCodeSame(204);
    }

    public function testUpdateUser()
    {
        $client = self::createClient();

        $email1 = self::getRandomEmail();
        $passw1 = self::PASSWORD_PLAIN_FOO;

        $user = $this->createUserAndLogin($client, $email1, $passw1);

        $client->request('PUT', '/api/users/' . $user->getId(), [
            'json' => [
                'username' => 'newusername',
                'roles' => ['ROLE_ADMIN'], //will be ignored as not exposed
            ]
        ]);

        self::assertResponseIsSuccessful();

        self::assertJsonContains(['username' => 'newusername']);

        $em = $this->getEntityManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($user->getId());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testGetUser()
    {
        $client = self::createClient();

        $email0 = self::getRandomEmail();
        $passw0 = self::PASSWORD_PLAIN_FOO;
        $phone0 = '666.111.' . time();
        $user0 = $this->createUserAndLogin($client, $email0, $passw0);
        $user0->setPhoneNumber($phone0);


        $email1 = self::getRandomEmail();
        $passw1 = self::PASSWORD_PLAIN_FOO;
        $phone1 = '555.111.' . time();
        $user1 = $this->createUserAndLogin($client, $email1, $passw1);
        $user1->setPhoneNumber($phone1);

        $em = $this->getEntityManager();
        $em->flush();

        /**
         * Test not having access to other people's phone number
         */
        $client->request('GET', '/api/users/' . $user0->getId());
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'email' => $email0
        ]);
        $data = $client->getResponse()->toArray();
        $this->assertArrayNotHasKey('phoneNumber', $data);

        /**
         * Test having access to my owner:read phone number
         */
        $client->request('GET', '/api/users/' . $user1->getId());
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
                                     'email' => $email1
                                 ]);
        $data = $client->getResponse()->toArray();
        $this->assertArrayHasKey('phoneNumber', $data);


        /**
         * Test admin:read
         * Set uset to admin, then access other people's phone
         */
        //refresh the user, because EntityManager loses it's state and track of
        //of entities after client->request
        $user1 = $em->getRepository(User::class)->find($user1->getId());
        $user1->setRoles(['ROLE_ADMIN']);
        $em->flush();
        #force updater roles for security system
        $this->login($client, $email1, $passw1);
        self::assertResponseIsSuccessful();
        $client->request('GET', '/api/users/' . $user0->getId());
        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'phoneNumber' => $phone0,
        ]);

    }
}

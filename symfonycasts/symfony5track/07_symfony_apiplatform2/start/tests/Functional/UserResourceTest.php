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
            'json' => ['username' => 'newusername']
        ]);

        self::assertResponseIsSuccessful();

        self::assertJsonContains(['username' => 'newusername']);
    }

    public function testGetUser()
    {
        $client = self::createClient();
        $email1 = self::getRandomEmail();
        $passw1 = self::PASSWORD_PLAIN_FOO;
        $user = $this->createUserAndLogin($client, $email1, $passw1);

        $user->setPhoneNumber('555.111.4567');
        $em = $this->getEntityManager();
        $em->flush();

        $client->request('GET', '/api/users/' . $user->getId());

        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            'email' => $email1
        ]);


        $data = $client->getResponse()->toArray();
        $this->assertArrayNotHasKey('phoneNumber', $data);




    }
}

<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\CheeseListing;
use App\Entity\User;
use App\Test\CustomApitestCase;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends CustomApitestCase
{
    private const PASSWORD_PLAINTEXT = 'foo';
    #private const PASSWORD_HASHED = '$argon2id$v=19$m=65536,t=4,p=1$9wWzG3E8mscDs2WRIdy66A$japO4VgQrQDGyZ2J4Cu3WZ4GRFnqgmrOHz6hgCkziLo';

    use ReloadDatabaseTrait;

//    private EntityManagerInterface $em;
//
//    public function setUp(): void
//    {
//        self::bootKernel();
//        $this->em = self::$container->get('doctrine')->getManager();
//        $this->em->beginTransaction();
//    }
//
//    public function tearDown(): void
//    {
//        $this->em->rollback();
//        parent::tearDown();
//    }

    public function testCreateCheeseListing(): void
    {
        $this->assertEquals(42, 42);

        $client = self::createClient();

        $client->request('POST', '/api/cheeses', [
           #'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        self::assertResponseStatusCodeSame(401);

        $email = bin2hex(random_bytes(4)) . '@' . bin2hex(random_bytes(4)) . '.com';
//        $this->createUser(
//            $email,
//            self::PASSWORD_PLAINTEXT
//        );
//
//        $this->login($client, $email, self::PASSWORD_PLAINTEXT);


        $this->createUserAndLogin($client, $email, self::PASSWORD_PLAINTEXT);
        self::assertResponseStatusCodeSame(204);

        $client->request('POST', '/api/cheeses', [
           #'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        self::assertResponseStatusCodeSame(422);
    }

    public function testCreateCheeseListing2(): void
    {
        $client = self::createClient();

        $email1 = self::getRandomEmail();
        $email2 = self::getRandomEmail();

        $user1 = $this->createUser($email1, self::PASSWORD_PLAINTEXT);
        $user2 = $this->createUser($email2, self::PASSWORD_PLAINTEXT);

        $this->login($client, $email1, self::PASSWORD_PLAINTEXT);
        self::assertResponseIsSuccessful();

        $cheezyData = [
            'title' => 'Mystery cheeze ' . time(),
            'description' => 'Fresh ' . time(),
            'price' => random_int(100, 5000)
        ];

        $client->request('POST', '/api/cheeses', [
            'json' => $cheezyData
        ]);
        self::assertResponseStatusCodeSame(422);

        /**
         * Trying to create cheeze for non-logged-in user (other user)
         * should still work for admin
         */
        $client->request('POST', '/api/cheeses', [
            'json' => $cheezyData + [
                'owner' => '/api/users/' . $user2->getId()
                ]
        ]);
        self::assertResponseStatusCodeSame(422, 'Passing owner != self');

        $client->request('POST', '/api/cheeses', [
            'json' => $cheezyData + [
                    'owner' => '/api/users/' . $user1->getId()
                ]
        ]);
        self::assertResponseStatusCodeSame(201, 'Passing owner == self');
    }

    public function testUpdateCheeseListing()
    {
        $email1 = self::getRandomEmail();
        $email2 = self::getRandomEmail();
        $client = self::createClient();

        $user1 = $this->createUser($email1, self::PASSWORD_PLAINTEXT);
        $user2 = $this->createUser($email2, self::PASSWORD_PLAINTEXT);

        $cheeseListing = new CheeseListing('Block of blob');
        $cheeseListing->setOwner($user1);
        $cheeseListing->setPrice(1000);
        $cheeseListing->setDescription(bin2hex(random_bytes(6)));

        $em = $this->getEntityManager();
        $em->persist($cheeseListing);
        $em->flush();

        $this->login($client, $email2, self::PASSWORD_PLAINTEXT);

        $client->request('PUT', '/api/cheeses/' . $cheeseListing->getId(), [
            'json' => ['title' => 'updatedtitle-' . time()]
        ]);

        self::assertResponseStatusCodeSame(403);
        self::assertStringContainsString('Only owner can edit cheese', $client->getResponse()->getContent(false));

        $this->login($client, $email1, self::PASSWORD_PLAINTEXT);
        $client->request('PUT', '/api/cheeses/' . $cheeseListing->getId(), [
            'json' => ['title' => 'updatedtitle-' . time()]
        ]);
        self::assertResponseStatusCodeSame(200);

    }
}
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

        self::assertResponseStatusCodeSame(201, 'Auto inserted owner by entity listener');

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
        $cheeseListing->setIsPublished(true);

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

    public function testGetCheeeseListingCollection()
    {
        $client = self::createClient();

        $email1 = self::getRandomEmail();
        $user = $this->createUser($email1, self::PASSWORD_PLAINTEXT);

        $cheeseListing1 = new CheeseListing('cheese1');
        $cheeseListing1->setOwner($user);
        $cheeseListing1->setPrice(1000);
        $cheeseListing1->setDescription('cheese');

        $cheeseListing2 = new CheeseListing('cheese2');
        $cheeseListing2->setOwner($user);
        $cheeseListing2->setPrice(2000);
        $cheeseListing2->setDescription('cheese');
        $cheeseListing2->setIsPublished(true);

        $cheeseListing3 = new CheeseListing('cheese3');
        $cheeseListing3->setOwner($user);
        $cheeseListing3->setPrice(3000);
        $cheeseListing3->setDescription('cheese');
        $cheeseListing3->setIsPublished(true);

        $em = $this->getEntityManager();

        $em->persist($cheeseListing1);
        $em->persist($cheeseListing2);
        $em->persist($cheeseListing3);

        $em->flush();

        $client->request('GET', '/api/cheeses');

        self::assertJsonContains(['hydra:totalItems' => 2]);

    }

    public function testGetCheeeseListingItem()
    {
        $client = self::createClient();

        $email1 = self::getRandomEmail();
        $user = $this->createUserAndLogin($client, $email1, self::PASSWORD_PLAINTEXT);

        $description = 'cheese-' . microtime();

        $cheeseListing1 = new CheeseListing('cheese1');
        $cheeseListing1->setOwner($user);
        $cheeseListing1->setPrice(1000);
        $cheeseListing1->setDescription($description);
        $cheeseListing1->setIsPublished(true);

        $cheeseListing2 = new CheeseListing('cheese2');
        $cheeseListing2->setOwner($user);
        $cheeseListing2->setPrice(1000);
        $cheeseListing2->setDescription($description);
        $cheeseListing2->setIsPublished(false); #default

        $em = $this->getEntityManager();

        $em->persist($cheeseListing1);
        $em->persist($cheeseListing2);

        $em->flush();

        $client->request('GET', '/api/cheeses/' . $cheeseListing1->getId());
        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['shortDescription' => $description]);

        $client->request('GET', '/api/cheeses/' . $cheeseListing2->getId());
        self::assertResponseStatusCodeSame(404);


        $em = $this->getEntityManager();
        /** @var CheeseListing $cheeseListing1 */
        $cheeseListing1 = $em->getRepository(CheeseListing::class)->find($cheeseListing1->getId());
        $cheeseListing1->setIsPublished(false);
        $em->persist($cheeseListing1);
        $em->flush();

        $client->request('GET', '/api/users/' . $user->getId());
        $data = $client->getResponse()->toArray();

        $this->assertEmpty($data['cheeseListings']);


    }
}
<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends ApiTestCase
{
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
            'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        self::assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('a@a9.com');
        $user->setUsername('iamaatadotcom8');
        #foo
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$9wWzG3E8mscDs2WRIdy66A$japO4VgQrQDGyZ2J4Cu3WZ4GRFnqgmrOHz6hgCkziLo');

//        $this->em->persist($user);
//        $this->em->flush();

        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['email' => 'a@a9.com', 'password' => 'foo']
        ]);

        self::assertResponseStatusCodeSame(204);
    }

}
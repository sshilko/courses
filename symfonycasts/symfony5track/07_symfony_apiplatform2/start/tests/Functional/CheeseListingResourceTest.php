<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CheeseListingResourceTest extends ApiTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $em */
        $this->em = self::$container->get('doctrine')->getManager();
        $this->em->beginTransaction();

//      #ths is the same as self::$container
//      $kernel = self::bootKernel();
//      $container = $kernel->getContainer();
//      $doctrine = $container->get('doctrine');
//      $em1 = $doctrine->getManager();
    }

    public function testCreateCheeseListing(): void
    {
        $this->assertEquals(42, 42);
        $client = self::createClient();
        $client->request('POST', '/api/cheeses', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        self::assertResponseStatusCodeSame(401);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
    }

    public function testCreateCheeseListingAuthed(): void
    {
        $user = new User();
        $user->setEmail('a@a3.com');
        $user->setUsername('iamaatadotcom3');
        #foo
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$wLzAcp6kcqrsYxKFXMYCXg$4o3519pdRmTqUMC7BIr25X4oX3R6/nccZfD21+DGNZI');

        $this->em->persist($user);
        $this->em->flush();

        $client = self::createClient();
        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['email' => 'a@a3.com', 'password' => 'foo']
        ]);

        self::assertResponseStatusCodeSame(204);
    }

}
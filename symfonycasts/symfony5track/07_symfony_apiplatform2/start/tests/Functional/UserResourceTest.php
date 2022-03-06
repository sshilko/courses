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
}

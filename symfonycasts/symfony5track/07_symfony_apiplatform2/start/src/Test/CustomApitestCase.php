<?php

namespace App\Test;
use \ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomApitestCase extends ApiTestCase
{
    protected function getEntityManager(): EntityManagerInterface
    {
        if (empty(self::$kernel)) {
            $kernel = self::bootKernel();
        } else {
            $kernel = self::$kernel;
        }
        return $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function createUser(string $email, string $plainPassword): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername(self::getRandomUsername());
        #foo
        #$user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$9wWzG3E8mscDs2WRIdy66A$japO4VgQrQDGyZ2J4Cu3WZ4GRFnqgmrOHz6hgCkziLo');

        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = self::$container->get('security.password_encoder')
            ->encodePassword($user, $plainPassword);
        $user->setPassword((string) $encoder);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function login(Client $client, string $email, string $plainPassword)
    {
        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => ['email' => $email, 'password' => $plainPassword]
        ]);
    }

    protected function createUserAndLogin(Client $client, $email, $password): User
    {
        $user = $this->createUser($email, $password);
        $this->login($client, $email, $password);
        return $user;

    }

    protected static function getRandomUsername(): string
    {
        return 'username-' . bin2hex(random_bytes(4)) . '-' . time();
    }

    protected static function getRandomEmail(): string
    {
        return bin2hex(random_bytes(4)) . '+' . time() . '@' . bin2hex(random_bytes(4)) . '.com';
    }

}
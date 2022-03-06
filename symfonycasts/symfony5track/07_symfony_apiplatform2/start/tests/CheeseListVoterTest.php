<?php

namespace App\Tests;

use App\Entity\CheeseListing;
use App\Entity\User;
use App\Security\Voter\CheeseListingVoter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CheeseListVoterTest extends KernelTestCase
{

    /**
     * Call protected or private method
     *
     * @param $object
     * @param $methodName
     * @param array $arguments
     * @return mixed
     */
    protected static function callMethod($object, $methodName, array $arguments = [])
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return empty($arguments)
            ? $method->invoke($object)
            : $method->invokeArgs($object, $arguments);
    }

    protected function getMockedUser(int $userId)
    {
        $mock = $this->getMockBuilder(User::class)
            ->getMock();
        $mock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($userId));

        return $mock;
    }

    public function testSomething(): void
    {
        self::bootKernel();

        $container = static::$container;

        $voter = $container->get(CheeseListingVoter::class);

        $this->assertTrue(
            self::callMethod($voter,
                              'supports',
                              [CheeseListingVoter::ALLOW_CHEESELISTING_EDIT, new CheeseListing()]
            )
        );

        $this->assertFalse(
            self::callMethod($voter,
                             'supports',
                             [bin2hex(random_bytes(random_int(2, 10))), new CheeseListing()]
            )
        );

        $mockedUser1 = $this->getMockedUser(33);
        $mockedUser2 = $this->getMockedUser(34);

        $token1 = new UsernamePasswordToken($mockedUser1, null, 'dummyfirewall1', ['ROLE_USER']);
        $token2 = new UsernamePasswordToken($mockedUser2, null, 'dummyfirewall2', ['ROLE_ADMIN']);

        $cheese1 = new CheeseListing();
        $cheese1->setOwner($mockedUser1);

        $this->assertTrue(
            self::callMethod(
                $voter,
                'voteOnAttribute',
                [
                    CheeseListingVoter::ALLOW_CHEESELISTING_EDIT,
                    $cheese1,
                    $token1
                ]
            )
        );

        /**
         * TODO create mocks for TokenInterface::class or UserNamePasswordToken etc.
         * then use those for checking security and roles etc.
         * @see https://github.com/symfony/symfony/blob/6.1/src/Symfony/Component/Security/Core/Tests/SecurityTest.php
         */

    }
}

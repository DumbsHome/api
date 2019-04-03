<?php

namespace App\Tests;

use App\Doctrine\RandomIdGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RandomIdGeneratorTest extends TestCase
{
    /** @var MockObject */
    private $em;
    /** @var RandomIdGenerator */
    private $randomIdGenerator;
    private $user;

    /**
     * Mocks the entityManager and the User entity.
     * Creates a new instance of the RandomIdGenerator
     */
    protected function setUp()
    {
        $this->em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(['getClassMetadata', 'find'])
            ->getMock();

        $classMetadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $this->em->method('getClassMetadata')->willReturn($classMetadata);

        $this->user = $this->getMockBuilder('App\Entity\User')
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomIdGenerator = new RandomIdGenerator();
    }

    public function testGenerateReturningAnId()
    {
        $this->em->method('find')->willReturn(null);
        $result = $this->randomIdGenerator->generate($this->em, $this->user);
        $this->assertTrue(strlen($result) == 48);
    }

    /**
     * @expectedException \Exception
     */
    public function testGenerateReturningAnException()
    {
        $this->em->method('find')->willReturn($this->user);
        $this->randomIdGenerator->generate($this->em, $this->user);
    }
}

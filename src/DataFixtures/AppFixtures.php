<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $adminUser = new User;
        $adminUser
            ->setEmail('contact@dumbshome.com')
            ->setPassword($this->passwordEncoder->encodePassword(
                $adminUser,
                'dev'
            ))
            ->setRoles(['ROLE_ADMIN'])
            ->setApiToken("637db9848c874cc5949d5609456121b9");

        $manager->persist($adminUser);
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@testaddnewgame.pl')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setPassword('blablabla')
            ->setIsVerified(1);
        $manager->persist($user);

        $manager->flush();
    }
}

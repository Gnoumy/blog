<?php

namespace blogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use blogBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 10) {
            $user = new User();
            $manager->persist($user);
            $i++;
        }
        $manager->flush();
    }

    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }

}

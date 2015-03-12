<?php

namespace blogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use blogBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
    function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 10) {
            $Category = new Category();
            $Category->setTitle('Titre du Category n°'.$i);
            $manager->persist($Category);
            $i++;
        }
        $manager->flush();
    }
}
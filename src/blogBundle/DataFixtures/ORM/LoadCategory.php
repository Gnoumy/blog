<?php

namespace blogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use blogBundle\Entity\Category;

class LoadCategory extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 10) {
            $category = new Category();
            $category->setTitle('Titre du Category n°'.$i);
            $manager->persist($category);

            $this->addReference('category-'.$i, $category);
            $i++;
        }
        $manager->flush();
    }


    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}

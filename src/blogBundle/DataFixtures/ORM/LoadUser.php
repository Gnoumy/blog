<?php

namespace blogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use blogBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 10) {
            $user = new User();
            $user->setUsername('user '.$i);
            $user->setEmail('user'.$i.'@esgi.fr');
            $user->setPassword('user');
            $manager->persist($user);

            $this->addReference('user-'.$i, $user);
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

<?php

namespace blogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use blogBundle\Entity\Post;

class LoadPost extends AbstractFixture implements OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 10) {

            $post = new Post();
            $post->setTitle('Titre du Post n°: '.$i);
            $post->setBody(' Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti possimus quod, voluptatem sit, vero earum voluptate tenetur. Recusandae illo!');
            $post->setIsPublished('Titre du Post n°:' .$i);
            $post->setDate(new \DateTime("11-11-1990"));
            $post->setAuteur('Auteur n°: '.$i);
            $post->setUser($this->getReference('user-'.$i));
            $post->setCategory($this->getReference('category-1'));
            $manager->persist($post);
            $i++;
        }

        $manager->flush();
    }

    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 3; // l'ordre dans lequel les fichiers sont chargés
    }
}

<?php

namespace blogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * postRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class postRepository extends EntityRepository
{
	public function findAll()
	{
		return $this->createQueryBuilder('p')
			->add('select', 'p')
			->add('where', 'p.is_published = :published')
			->add('orderBy', 'p.created_at DESC')
			->setParameter('published', true)
			->getResult();
	}


}

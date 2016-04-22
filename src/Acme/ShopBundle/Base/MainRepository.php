<?php

namespace Acme\ShopBundle\Base;

use Doctrine\ORM\EntityRepository;

class MainRepository extends EntityRepository
{
	private function generateAlias () {
		$entityName = $this->getEntityName();
    $namePath = explode("\\", $entityName);
    $name = end($namePath);
    preg_match_all("/[^a-z]/", $name, $match);
    $arrUppercaseLetter = $match[0];
		$alias = implode($arrUppercaseLetter);
		return $alias;
	}

	public function paginatedSearch ($search)
	{
		$alias = $this->generateAlias();
		$qb    = $this->createQueryBuilder($alias);
		$em    = $this->getEntityManager();
		$meta  = $em->getClassMetadata($this->getEntityName());
		
		foreach ($search as $key => $value) {
			if ($meta->hasField($key)) {
				$qb->andWhere($qb->expr()->eq($alias.'.'.$key, ':'.$key));
				$qb->setParameter($key, $value);
			}
		}
		return $qb->getQuery()->getResult();
	}
}
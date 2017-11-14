<?php 
namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

class StatusreportsRepository extends EntityRepository {
	public function findAll() {
		return $this->getEntityManager()
			->createQuery(
				'SELECT s FROM AppBundle:Statusreports s'
			)
			->getResult();
	}
}
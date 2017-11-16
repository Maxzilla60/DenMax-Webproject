<?php
namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class ProblemsRepository extends EntityRepository {
    public function findAll() {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Problems p'
            )
            ->getResult();
    }
}
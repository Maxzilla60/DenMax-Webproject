<?php

namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\ProblemsRepository;
use AppBundle\Entity\Problems;

class ProblemsService {
    private $entityManager;
    private $problemsRepository;

    public function __construct(EntityManager $entityManager, ProblemsRepository $problemsRepository) {
        $this->entityManager = $entityManager;
        $this->problemsRepository = $problemsRepository;
    }

    public function fetchAllProblems() {
        $problems = $this->problemsRepository->findAll();
        return $problems;
    }
}
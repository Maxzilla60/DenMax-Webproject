<?php

namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\StatusreportsRepository;
use AppBundle\Entity\Statusreports;

class StatusreportsService {
	private $entityManager;
	private $statusreportsRepository;

	public function __construct(EntityManager $entityManager, StatusreportsRepository $statusreportsRepository) {
		$this->entityManager = $entityManager;
		$this->statusreportsRepository = $statusreportsRepository;
	}

	public function fetchAllStatusreports() {
		$statusreports = $this->statusreportsRepository->findAll();
		return $statusreports;
	}
}
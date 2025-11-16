<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ApplicationDTO;
use App\Entity\Application;
use App\Repository\ApplicationRepository;

class ApplicationService
{
    public function __construct(
        private readonly ApplicationRepository $applicationRepository
    ) {
    }

    public function create(ApplicationDTO $applicationDTO): void
    {
        $application = new Application();
        $application->setEmail($applicationDTO->getEmail());
        $application->setPhoneNumber($applicationDTO->getPhoneNumber());
        $application->setFirstname($applicationDTO->getFirstname());
        $application->setLastname($applicationDTO->getLastname());
        $application->setMiddlename($applicationDTO->getMiddlename());
        $application->setTelegramID($applicationDTO->getTelegramID());
        $application->setDescription($applicationDTO->getDescription());

        $this->applicationRepository->persist($application);

    }
}

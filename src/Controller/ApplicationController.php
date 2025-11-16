<?php

namespace App\Controller;

use App\DTO\ApplicationDTO;
use App\UseCase\SubmitApplicationUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route("/api/1.0/applications", name: 'api.1_0.applications.')]
final class ApplicationController extends AbstractController
{
    public function __construct(
        private SubmitApplicationUseCase $submitApplicationUseCase,
    ) {
    }

    #[Route('/submit', name: 'submit', methods: ['POST'])]
    public function submit(#[MapRequestPayload] ApplicationDTO $application): Response
    {
        $this->submitApplicationUseCase->execute($application);

        return new Response();
    }
}

<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Client\TelegramClient;
use App\DTO\ApplicationDTO;
use App\Factory\TelegramMessageFactory;
use App\Service\ApplicationEmailService;
use App\Service\ApplicationService;

readonly class SubmitApplicationUseCase
{
    public function __construct(
        private TelegramClient $telegramClient,
        private TelegramMessageFactory $telegramMessageFactory,
        private ApplicationEmailService $emailService,
        private ApplicationService $applicationService,
    ) {
    }

    public function execute(ApplicationDTO $application): void
    {
        $this->applicationService->create($application);

        $message = $this->telegramMessageFactory->createFromApplication($application);

        $this->telegramClient->sendMessage($message);

        // $this->emailService->sendConfirmation($application);
    }
}

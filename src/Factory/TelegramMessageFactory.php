<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\ApplicationDTO;
use App\Model\TelegramMessage;

final class TelegramMessageFactory
{
    private const string MESSAGE_FORMAT = "
*Новая заявка для Пабло и Ромеро!*\n
Имя клиента: %s\n
Фамилия клиента: %s\n
Отчество клиента: %s\n
Номер телефона: %s \n
Email: %s\n
    ";

    private const string TG_ID_FORMAT = "Telegram ID: %s\n";

    private const string DESCRIPTION_FORMAT = "Доп. информация: %s\n";

    public function createFromApplication(ApplicationDTO $application): TelegramMessage
    {
        $message = sprintf(
            self::MESSAGE_FORMAT,
            $application->getFirstname(),
            $application->getLastname(),
            $application->getMiddlename(),
            $application->getPhoneNumber(),
            $application->getEmail(),

        );

        if ($application->getTelegramID() !== null) {
            $message .= sprintf(self::TG_ID_FORMAT, $application->getTelegramID());
        }


        if ($application->getDescription() !== null) {
            $message .= sprintf(self::DESCRIPTION_FORMAT, $application->getDescription());
        }

        return new TelegramMessage($message);
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\ApplicationDTO;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class ApplicationEmailService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $fromEmail = 'noreply@pabloromero.com',
    ) {
    }

    public function sendConfirmation(ApplicationDTO $application): void
    {
        $email = (new Email())
            ->from($this->fromEmail)
            ->to($application->getEmail())
            ->subject('Ваша заявка принята')
            ->html($this->getEmailBody($application));

        $this->mailer->send($email);
    }

    private function getEmailBody(ApplicationDTO $application): string
    {
        $fullName = sprintf(
            '%s %s %s',
            $application->getLastname(),
            $application->getFirstname(),
            $application->getMiddlename()
        );

        return sprintf(
            '<html>
                <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #2c3e50;">Здравствуйте, %s!</h2>
                        
                        <p>Спасибо за вашу заявку!</p>
                        
                        <p>Мы получили вашу заявку и в ближайшее время свяжемся с вами.</p>
                        
                        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                            <h3 style="margin-top: 0; color: #495057;">Информация о вашей заявке:</h3>
                            <p><strong>Имя:</strong> %s</p>
                            <p><strong>Email:</strong> %s</p>
                            <p><strong>Телефон:</strong> %s</p>
                            %s
                        </div>
                        
                        <p>Если у вас возникли вопросы, вы можете связаться с нами по email или телефону.</p>
                        
                        <p style="color: #6c757d; font-size: 0.9em; margin-top: 30px;">
                            С уважением,<br>
                            Команда Pablo Romero
                        </p>
                    </div>
                </body>
            </html>',
            htmlspecialchars($application->getFirstname()),
            htmlspecialchars($fullName),
            htmlspecialchars($application->getEmail()),
            htmlspecialchars($application->getPhoneNumber()),
            $application->getDescription() 
                ? '<p><strong>Описание:</strong> ' . htmlspecialchars($application->getDescription()) . '</p>'
                : ''
        );
    }
}

<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class ApplicationDTO
{
    public function __construct(
        #[Assert\NotBlank]
        private string $firstname,
        #[Assert\NotBlank]
        private string $lastname,
        #[Assert\NotBlank]
        private string $middlename,
        #[
            Assert\NotBlank,
            Assert\Email
        ]
        private string $email,
        #[
            Assert\NotBlank,
            Assert\Regex(
                pattern: '/^\+?[0-9\s\-\(\)]{7,20}$/',
                message: 'The phone number is not valid.'
            )
        ]
        private string $phoneNumber,
        private ?string $telegramID = null,
        private ?string $description = null
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->middlename = $middlename;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->telegramID = $telegramID;
        $this->description = $description;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getMiddlename(): string
    {
        return $this->middlename;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getTelegramID(): ?string
    {
        return $this->telegramID;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}

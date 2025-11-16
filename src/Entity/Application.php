<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity]
#[ORM\Table(name: "application")]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $firstname;

    #[ORM\Column(type: Types::STRING)]
    private string $lastname;

    #[ORM\Column(type: Types::STRING)]
    private string $middlename;

    #[ORM\Column(type: Types::STRING)]
    private string $email;

    #[ORM\Column(type: Types::STRING, name: 'phone_number')]
    private string $phoneNumber;

    #[ORM\Column(type: Types::STRING, nullable: true, name: 'telegram_id')]
    private ?string $telegramID = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function setMiddlename(string $middlename): self
    {
        $this->middlename = $middlename;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getTelegramID(): ?string
    {
        return $this->telegramID;
    }

    public function setTelegramID(?string $telegramID): self
    {
        $this->telegramID = $telegramID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}

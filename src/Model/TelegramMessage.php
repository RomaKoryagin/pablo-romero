<?php

declare(strict_types=1);

namespace App\Model;

final class TelegramMessage
{
    public function __construct(private string $value)
    {
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

<?php

namespace App\Container;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class TelegramCredentialsContainer
{
    public function __construct(
        #[Autowire(env: 'TELEGRAM_BOT_TOKEN')]
        private string $token,
        #[Autowire(env: 'TELEGRAM_CHAT_ID')]
        private string $chatId
    ) {
        $this->token = $token;
        $this->chatId = $chatId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }
}

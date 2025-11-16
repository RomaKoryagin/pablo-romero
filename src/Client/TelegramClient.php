<?php

declare(strict_types=1);

namespace App\Client;

use App\Container\TelegramCredentialsContainer;
use App\Model\TelegramMessage;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Exception\TelegramException;

class TelegramClient
{
    private const string CHAT_ID_KEY = 'chat_id';
    private const string TEXT_KEY = 'text';
    private const string PARSE_MODE_KEY = 'parse_mode';

    private const string DEFAULT_PARSE_MODE = 'MarkdownV2';

    private Telegram $telegram;

    public function __construct(
        private TelegramCredentialsContainer $telegramCredentials
    ) {
        try {
            $this->telegram = new Telegram(
                $this->telegramCredentials->getToken(),
                'pablo_romero_bot'
            );
        } catch (TelegramException $e) {
            throw new \RuntimeException('Failed to initialize Telegram bot: ' . $e->getMessage(), 0, $e);
        }
    }

    public function sendMessage(TelegramMessage $message): void
    {
        try {
            Request::sendMessage([
                static::CHAT_ID_KEY => $this->telegramCredentials->getChatId(),
                static::TEXT_KEY  => $this->escapeMarkdownV2($message->getValue()),
                static::PARSE_MODE_KEY => self::DEFAULT_PARSE_MODE,
            ]);
        } catch (TelegramException $e) {
            throw new \RuntimeException('Failed to send Telegram message: ' . $e->getMessage(), 0, $e);
        }
    }

    private function escapeMarkdownV2(string $text): string
    {
        // Split by markdown syntax to preserve bold/italic markers
        // Escape everything except intentional markdown
        $parts = preg_split('/(\*[^*]+\*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        $result = [];
        foreach ($parts as $i => $part) {
            // Odd indices are captured groups (markdown bold text)
            if ($i % 2 === 1) {
                // This is markdown - escape only the content inside
                $content = trim($part, '*');
                $escapedContent = $this->escapeMarkdownContent($content);
                $result[] = '*' . $escapedContent . '*';
            } else {
                // Regular text - escape everything
                $result[] = $this->escapeMarkdownContent($part);
            }
        }
        
        return implode('', $result);
    }

    private function escapeMarkdownContent(string $text): string
    {
        // Characters that need to be escaped in MarkdownV2
        $specialChars = ['_', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        
        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        
        return $text;
    }
}

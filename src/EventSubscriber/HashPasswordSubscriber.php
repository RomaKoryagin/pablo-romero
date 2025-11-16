<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'hashPassword',
            BeforeEntityUpdatedEvent::class => 'hashPassword',
        ];
    }

    public function hashPassword(BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof User) {
            return;
        }

        $plainPassword = $entity->getPassword();

        if (empty($plainPassword)) {
            return;
        }

        if (str_starts_with($plainPassword, '$2y$')) {
            return;
        }

        $hashedPassword = $this->passwordHasher->hashPassword($entity, $plainPassword);
        $entity->setPassword($hashedPassword);
    }
}

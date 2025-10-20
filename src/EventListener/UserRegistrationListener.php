<?php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsEventListener(event: UserRegisteredEvent::class)]
class UserRegistrationListener
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(UserRegisteredEvent $event): void
    {
        $user = $this->userRepository->find($event->getUserId());

        if (!$user) {
            return;
        }

        $email = (new Email())
            ->from('noreply@my-app.com')
            ->to($user->getEmail())
            ->subject('Welcome to our platform!')
            ->html('<p>Thank you for registering!</p>');

        $this->mailer->send($email);
    }
}

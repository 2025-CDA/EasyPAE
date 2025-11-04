<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// THIS FILE IS FOR TESTING AND USER CREATION DURING TESTING ONLY
readonly class UserStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private MailerInterface $mailer
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof User &&
            $data->getPlainPassword() &&
            ($operation->getMethod() === 'POST' || $operation->getMethod() === 'PATCH')
        ) {
            $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPlainPassword());
            $data->setPassword($hashedPassword);
            $data->eraseCredentials(); // Nulls out the plainPassword
        }

        $persistedUser = $this->persistProcessor->process($data, $operation, $uriVariables, $context);

        if ($persistedUser instanceof User && $operation->getMethod() === 'POST') {
            $message = (new Email())
                ->from('registration@easypae.com')
                ->to($persistedUser->getEmail())
                ->subject('A new user account has been created')
                ->text(sprintf('The user #%d has been created.', $persistedUser->getId()));

            $this->mailer->send($message);
        }

        return $persistedUser;
    }
}

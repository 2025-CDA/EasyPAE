<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// Added to access the current HTTP request
use Symfony\Component\HttpFoundation\RequestStack;

readonly class UserStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private MailerInterface $mailer,
        // Inject RequestStack to access the current request
        private RequestStack $requestStack
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Get the current HTTP request method
        $request = $this->requestStack->getCurrentRequest();
        $httpMethod = $request?->getMethod();

        if (
            $data instanceof User &&
            $data->getPlainPassword() &&
            // Only hash password on creation or update
            ($httpMethod === 'POST' || $httpMethod === 'PATCH')
        ) {
            $hashedPassword = $this->passwordHasher->hashPassword($data, $data->getPlainPassword());
            $data->setPassword($hashedPassword);
            $data->eraseCredentials(); // Nulls out the plainPassword
        }

        $persistedUser = $this->persistProcessor->process($data, $operation, $uriVariables, $context);

        if ($persistedUser instanceof User && $httpMethod === 'POST') {
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

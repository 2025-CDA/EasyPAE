<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;

final class JWTCreatedListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    #[AsEventListener(event: 'lexik_jwt_authentication.on_jwt_created')]
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        // Safety check: if the listener is somehow called outside of a request, do nothing.
        if (null === $request) {
            return;
        }

        // 1. Get the current payload and the user object
        $payload = $event->getData();
        $user = $event->getUser();

        // 2. Make sure the user is an instance of your User class
        if (!$user instanceof User) {
            return;
        }

        unset($payload['username']);

        // 3. ADD data to the payload
        // For example, add the user's ID and full name.
        $payload['id'] = $user->getId();
        $payload['fullName'] = $user->getFullName(); // Assuming you have a getFullName() method

        // 4. REMOVE data from the payload
        // For example, you might decide not to expose the roles directly in the token.
        $payload['roles'];

        // 5. CHANGE existing data in the payload
        // The default "username" key is the user identifier. Let's make it more explicit.
        // Note: Many front-end clients expect the "username" claim, so changing it
        // might be a breaking change. Adding a new key is often safer.
        $payload['email'] = $user->getUserIdentifier(); // Add an explicit "email" key

        $payload['ip'] = $request->getClientIp();


        // 6. Set the modified payload back on the event
        $event->setData($payload);
    }
}

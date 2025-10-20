<?php
//
//namespace App\EventListener;
//
//use App\Entity\User;
//use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Event\ResponseEvent;
//use Symfony\Component\HttpKernel\Event\TerminateEvent;
//use Symfony\Component\HttpKernel\KernelEvents;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;
//
//final class UserRegistrationMailListener
//{
//    // This will temporarily hold the user between events
//    private ?User $user = null;
//
//    public function __construct(private readonly MailerInterface $mailer)
//    {
//    }
//
//    /**
//     * Step 1: Listen to kernel.response. This event is GUARANTEED to fire.
//     * We inspect the request and response to see if our conditions are met.
//     */
//    #[AsEventListener(event: KernelEvents::RESPONSE)]
//    public function checkResponseAndGrabUser(ResponseEvent $event): void
//    {
//        $request = $event->getRequest();
//        $response = $event->getResponse();
//
//        // Get the entity from the request attributes, where API Platform stores it.
//        $user = $request->attributes->get('data');
//
//        // Check our conditions:
//        // 1. Is the entity a User?
//        // 2. Was the request method a POST?
//        // 3. Was the final response a 201 Created?
//        if (
//            !$user instanceof User ||
//            $request->getMethod() !== Request::METHOD_POST ||
//            $response->getStatusCode() !== Response::HTTP_CREATED
//        ) {
//            return;
//        }
//
//        // All conditions met! Store the User object for the next event.
//        $this->user = $user;
//    }
//
//    /**
//     * Step 2: Send the email after the response has been sent to the client.
//     */
//    #[AsEventListener(event: KernelEvents::TERMINATE)]
//    public function sendMailOnTerminate(TerminateEvent $event): void
//    {
//        // If the first listener didn't store a user, do nothing.
//        if (null === $this->user) {
//            return;
//        }
//
//        $message = (new Email())
//            ->from('registration@easypae.com')
//            ->to($this->user->getEmail())
//            ->subject('A new user account has been created')
//            ->text(sprintf('The user #%d has been created.', $this->user->getId()));
//
//        $this->mailer->send($message);
//    }
//}

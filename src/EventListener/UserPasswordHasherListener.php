<?php
//
//namespace App\EventListener;
//
//use App\Entity\User;
//use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
//use Doctrine\ORM\Events;
//use Doctrine\Persistence\Event\LifecycleEventArgs;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//
//#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
//#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
//final readonly class UserPasswordHasherListener
//{
//    public function __construct(private UserPasswordHasherInterface $passwordHasher)
//    {
//    }
//
//    public function prePersist(LifecycleEventArgs $args): void
//    {
////        dd('Hasher Subscriber prePersist method was called!');
//        $this->hashPassword($args);
//    }
//
//    public function preUpdate(LifecycleEventArgs $args): void
//    {
//        $this->hashPassword($args);
//    }
//
//    private function hashPassword(LifecycleEventArgs $args): void
//    {
//        $entity = $args->getObject();
//
//        // We only care about User entities that have a plain password set.
//        if (!$entity instanceof User || null === $entity->getPlainPassword()) {
//            return;
//        }
//
//        // Hash the plain password and set it on the entity.
//        $hashedPassword = $this->passwordHasher->hashPassword(
//            $entity,
//            $entity->getPlainPassword()
//        );
//        $entity->setPassword($hashedPassword);
//
//        // Erase the plain password for security.
//        $entity->eraseCredentials();
//    }
//}

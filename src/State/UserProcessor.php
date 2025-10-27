<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\UserDTO;
use App\Repository\UserRepository;
use App\Repository\UserNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserNotificationRepository $userNotificationRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UserDTO
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'update_user_info' => $this->updateUserInfo($data, $uriVariables),
            'update_user_preferences' => $this->updateUserPreferences($data, $uriVariables),
            'mark_notification_as_read' => $this->markNotificationAsRead($data ?? new UserDTO(), $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function updateUserInfo(UserDTO $data, array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        if ($data->firstName !== null) {
            $user->setFirstName($data->firstName);
        }
        if ($data->lastName !== null) {
            $user->setLastName($data->lastName);
        }
        if ($data->email !== null) {
            $user->setEmail($data->email);
        }
        if ($data->avatar !== null) {
            $user->setAvatar($data->avatar);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_info_updated';
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->email = $user->getEmail();
        $dto->avatar = $user->getAvatar();

        return $dto;
    }

    private function updateUserPreferences(UserDTO $data, array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        if ($data->notification !== null) {
            $user->setNotification($data->notification);
        }
        if ($data->darkMode !== null) {
            $user->setDarkMode($data->darkMode);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_preferences_updated';
        $dto->notification = $user->isNotification();
        $dto->darkMode = $user->isDarkMode();

        return $dto;
    }

    private function markNotificationAsRead(UserDTO $data, array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        $notificationId = $uriVariables['notificationId'] ?? null;

        if (!$userId || !$notificationId) {
            throw new BadRequestHttpException('User ID and Notification ID are required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userNotification = $this->userNotificationRepository->findOneBy([
            'user' => $user,
            'notification' => $notificationId
        ]);

        if (!$userNotification) {
            throw new NotFoundHttpException('Notification not found for this user');
        }

        $userNotification->setIsRead(true);

        $this->entityManager->persist($userNotification);
        $this->entityManager->flush();

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_notification_' . $notificationId . '_read';
        $dto->isRead = true;

        return $dto;
    }
}
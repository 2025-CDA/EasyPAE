<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\UserDTO;
use App\Repository\UserRepository;
use App\Repository\UserNotificationRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserProvider implements ProviderInterface
{
    public function __construct(
        private UserRepository             $userRepository,
        private UserNotificationRepository $userNotificationRepository,
//        private NotificationRepository     $notificationRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'user_basic_info' => $this->getUserBasicInfo($uriVariables),
            'user_info' => $this->getUserInfo($uriVariables),
            'user_preferences' => $this->getUserPreferences($uriVariables),
            'user_notifications' => $this->getUserNotifications($uriVariables),
            'user_notification_detail' => $this->getUserNotificationDetail($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function getUserBasicInfo(array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $dto = new UserDTO();
        $dto->id = 'user_basic_' . $userId;
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->avatar = $user->getAvatar();
        $dto->email = $user->getEmail();



        $dto->roles = $user->getRoles();





        return $dto;
    }

    private function getUserInfo(array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_info';
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->email = $user->getEmail();
        $dto->avatar = $user->getAvatar();
        $dto->phone = $user->getPhone();
        $dto->birthday = $user->getBirthday() ? $user->getBirthday()->format('Y-m-d') : null;
        $dto->address = $user->getAddress();


        return $dto;
    }

    private function getUserPreferences(array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_preferences';
        $dto->notification = $user->isNotification();
        $dto->darkMode = $user->isDarkMode();

        return $dto;
    }

    private function getUserNotifications(array $uriVariables): UserDTO
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userNotificationsEntities = $this->userNotificationRepository->findBy(['user' => $user]);
        $notifications = [];

        foreach ($userNotificationsEntities as $userNotification) {
            if ($userNotification) {
                $notifications[] = [
                    'id' => $userNotification->getId(),
                    'title' => $userNotification->getTitle(),
                    'isRead' => $userNotification->isRead(),
                    'isSigned'=> $userNotification->isSigned(),
                ];
            }
        }

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_notifications';
        $dto->notifications = $notifications;

        return $dto;
    }

    private function getUserNotificationDetail(array $uriVariables): UserDTO
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
            'id' => $notificationId
        ]);

        if (!$userNotification) {
            throw new NotFoundHttpException('Notification not found for this user');
        }

        $dto = new UserDTO();
        $dto->id = 'user_' . $userId . '_notification_' . $notificationId . '_detail';
        $dto->title = $userNotification->getTitle();
        $dto->content = $userNotification->getContent();
        $dto->isRead = $userNotification->isRead();
        $dto->isSigned = $userNotification->isSigned();

        return $dto;
    }
}

<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\State\UserProvider;
use App\State\UserProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user/{userId}',
            uriVariables: ['userId'],
            provider: UserProvider::class,
            name: 'user_basic_info',
            normalizationContext: ['groups' => ['read:user_basic']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
        ),

        new Get(
            uriTemplate: '/account/{userId}/info',
            uriVariables: ['userId'],
            provider: UserProvider::class,
            name: 'user_info',
            normalizationContext: ['groups' => ['read:user_info']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
        ),
        new Patch(
            uriTemplate: '/account/{userId}/info',
            uriVariables: ['userId'],
            processor: UserProcessor::class,
            name: 'update_user_info',
            denormalizationContext: ['groups' => ['write:user_info']],
            normalizationContext: ['groups' => ['read:user_info']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            read: false,
        ),

        new Get(
            uriTemplate: '/account/{userId}/preferences',
            uriVariables: ['userId'],
            provider: UserProvider::class,
            name: 'user_preferences',
            normalizationContext: ['groups' => ['read:user_preferences']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
        ),
        new Patch(
            uriTemplate: '/account/{userId}/preferences',
            uriVariables: ['userId'],
            processor: UserProcessor::class,
            name: 'update_user_preferences',
            denormalizationContext: ['groups' => ['write:user_preferences']],
            normalizationContext: ['groups' => ['read:user_preferences']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            read: false,
        ),

        new Get(
            uriTemplate: '/notifications/user/{userId}',
            uriVariables: ['userId'],
            provider: UserProvider::class,
            name: 'user_notifications',
            normalizationContext: ['groups' => ['read:user_notifications']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
        ),

        new Get(
            uriTemplate: '/notifications/user/{userId}/show/{notificationId}',
            uriVariables: ['userId', 'notificationId'],
            provider: UserProvider::class,
            name: 'user_notification_detail',
            normalizationContext: ['groups' => ['read:user_notification_detail']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
        ),
        new Patch(
            uriTemplate: '/notifications/user/{userId}/sign/{notificationId}',
            uriVariables: ['userId', 'notificationId'],
            processor: UserProcessor::class,
            name: 'mark_notification_as_read',
            normalizationContext: ['groups' => ['read:notification_status']],
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            read: false,
            deserialize: false,
        ),
    ],
)]
class UserDTO
{
    #[ApiProperty(identifier: true)]
    public ?string $id = null;

    #[Groups([
        'read:user_basic',
        'read:user_info',
        'write:user_info'
    ])]
    public ?string $firstName = null;

    #[Groups([
        'read:user_basic',
        'read:user_info',
        'write:user_info'
    ])]
    public ?string $lastName = null;

    #[Groups([
        'read:user_basic',
        'read:user_info',
        'write:user_info'
    ])]
    public ?string $avatar = null;

    #[Groups([
        'read:user_info',
        'write:user_info'
    ])]
    public ?string $email = null;

    #[Groups([
        'read:user_preferences',
        'write:user_preferences'
    ])]
    public ?bool $notification = null;

    #[Groups([
        'read:user_preferences',
        'write:user_preferences'
    ])]
    public ?bool $darkMode = null;

    #[Groups([
        'read:user_notifications',
        'read:user_notification_detail',
        'read:notification_status'
    ])]
    public ?string $title = null;

    #[Groups([
        'read:user_notification_detail'
    ])]
    public ?string $content = null;

    #[Groups([
        'read:user_notifications',
        'read:user_notification_detail',
        'read:notification_status'
    ])]
    public ?bool $isRead = null;

    #[Groups([
        'read:user_notifications'
    ])]
    public ?array $notifications = null;

    #[Groups(['read:notification_status'])]
    public ?string $message = null;
}

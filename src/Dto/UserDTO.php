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
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_basic']],
            name: 'user_basic_info',
            provider: UserProvider::class,
        ),

        new Get(
            uriTemplate: '/account/{userId}/info',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_info']],
            name: 'user_info',
            provider: UserProvider::class,
        ),
        new Patch(
            uriTemplate: '/account/{userId}/info',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_info']],
            denormalizationContext: ['groups' => ['write:user_info']],
            read: false,
            name: 'update_user_info',
            processor: UserProcessor::class,
        ),

        new Get(
            uriTemplate: '/account/{userId}/preferences',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_preferences']],
            name: 'user_preferences',
            provider: UserProvider::class,
        ),
        new Patch(
            uriTemplate: '/account/{userId}/preferences',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_preferences']],
            denormalizationContext: ['groups' => ['write:user_preferences']],
            read: false,
            name: 'update_user_preferences',
            processor: UserProcessor::class,
        ),

        new Get(
            uriTemplate: '/notifications/user/{userId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:user_notifications']],
            name: 'user_notifications',
            provider: UserProvider::class,
        ),

        new Get(
            uriTemplate: '/notifications/user/{userId}/show/{notificationId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId', 'notificationId'],
            normalizationContext: ['groups' => ['read:user_notification_detail']],
            name: 'user_notification_detail',
            provider: UserProvider::class,
        ),
        new Patch(
            uriTemplate: '/notifications/user/{userId}/sign/{notificationId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId', 'notificationId'],
            normalizationContext: ['groups' => ['read:notification_status']],
            read: false,
            deserialize: false,
            name: 'mark_notification_as_read',
            processor: UserProcessor::class,
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

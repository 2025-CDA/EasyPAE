<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\UserDTO;
use App\Entity\Company;
use App\Entity\CompanyMember;
use App\Entity\User;
use App\Enum\CompanyRole;
use App\Enum\UserRole;
use App\Repository\CompanyMemberRepository;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use App\Repository\UserNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserProcessor implements ProcessorInterface
{
    public function __construct(
        private UserRepository             $userRepository,
        private UserNotificationRepository $userNotificationRepository,
        private CompanyRepository          $companyRepository,
        private CompanyMemberRepository    $companyMemberRepository,
        private EntityManagerInterface     $entityManager,
        private RequestStack               $requestStack,
        private string                     $projectDir,
        private UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UserDTO|null
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'update_user_info' => $this->updateUserInfo($data, $uriVariables),
            'update_user_preferences' => $this->updateUserPreferences($data, $uriVariables),
            'mark_notification_as_read' => $this->markNotificationAsRead($data ?? new UserDTO(), $uriVariables),
            'upload_user_avatar' => $this->uploadUserAvatar($uriVariables),
            'user_companyMember' => $this->createCompanyMemberAndCompany($data),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function updateUserInfo(UserDTO $data, array $uriVariables): UserDTO|null
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

    private function updateUserPreferences(UserDTO $data, array $uriVariables): UserDTO|null
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

    private function markNotificationAsRead(UserDTO $data, array $uriVariables): UserDTO|null
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

    private function uploadUserAvatar(array $uriVariables): UserDTO|null
    {
        $userId = $uriVariables['userId'] ?? null;
        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request?->files->get('avatar');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('No avatar file uploaded');
        }

        $oldAvatar = $user->getAvatar();
        if ($oldAvatar) {
            $oldFilePath = $this->projectDir . '/public/uploads/avatars/' . $oldAvatar;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $filename = uniqid('', true) . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move(
            $this->projectDir . '/public/uploads/avatars',
            $filename
        );

        $user->setAvatar($filename);
        $this->entityManager->flush();

        $dto = new UserDTO();
        $dto->id = (string) $userId;
        $dto->avatar = '/uploads/avatars/' . $filename;
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();

        return $dto;
    }

    private function createCompanyMemberAndCompany(UserDTO $data): UserDTO|null
    {
        if (!$data->firstName || !$data->lastName || !$data->email || !$data->plainPassword) {
            throw new BadRequestHttpException('First name, last name, email and password are required');
        }

        $existingUser = $this->userRepository->findOneBy(['email' => $data->email]);
        if ($existingUser) {
            throw new BadRequestHttpException('A user with this email already exists');
        }

        $user = new User();
        $user->setFirstName($data->firstName);
        $user->setLastName($data->lastName);
        $user->setEmail($data->email);
        $user->setLogin($data->login);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $data->plainPassword);
        $user->setPassword($hashedPassword);

        if ($data->phoneNumber) {
            $user->setPhone($data->phoneNumber);
        }
        if ($data->address) {
            $user->setAddress($data->address);
        }
        if ($data->birthday) {
            $user->setBirthday(new \DateTimeImmutable($data->birthday));
        }

        $user->setRole(UserRole::COMPANY);

        $this->entityManager->persist($user);


        $company = null;

        if ($data->siret) {

            $company = $this->companyRepository->findOneBy(['siret' => $data->siret]);

            if (!$company) {

                if (!$data->companyName) {
                    throw new BadRequestHttpException('Company name is required when creating a new company');
                }

                $company = new Company();
                $company->setSiret($data->siret);
                $company->setName($data->companyName);

                if ($data->companyPhoneNumber) {
                    $company->setPhoneNumber($data->companyPhoneNumber);
                }
                if ($data->companyAddress) {
                    $company->setAddress($data->companyAddress);
                }

                $this->entityManager->persist($company);
            }
        } elseif ($data->companyName) {

            $company = new Company();
            $company->setName($data->companyName);

            if ($data->companyPhoneNumber) {
                $company->setPhoneNumber($data->companyPhoneNumber);
            }
            if ($data->companyAddress) {
                $company->setAddress($data->companyAddress);
            }

            $this->entityManager->persist($company);
        }

        if ($company) {

            $existingMembership = $this->companyMemberRepository->findOneBy([
                'user' => $user,
                'company' => $company
            ]);

            if (!$existingMembership) {
                $companyMember = new CompanyMember();
                $companyMember->setUser($user);
                $companyMember->setCompany($company);

                if ($data->isLegalRepresentative === true) {
                    $companyMember->setRole(CompanyRole::LEGAL_REPRESENTATIVE);
                } else {
                    $companyMember->setRole(CompanyRole::TUTOR);
                }

                $this->entityManager->persist($companyMember);
            }
        }

        $this->entityManager->flush();

        $dto = new UserDTO();
        $dto->id = $user->getId();
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->email = $user->getEmail();

        if ($company) {
            $dto->companyName = $company->getName();
            $dto->siret = $company->getSiret();
        }

        return $dto;
    }


}

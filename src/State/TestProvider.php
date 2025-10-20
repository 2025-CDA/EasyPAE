<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Test;
use App\Entity\User; // Assuming your user entity is here
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This provider is responsible for creating and returning Test DTOs.
 * It fetches real User entities and maps them to the simpler DTO.
 *
 * @implements ProviderInterface<Test>
 */
class TestProvider implements ProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * Provides the data for the Test resource.
     * It handles both single item (GET /test/{userId}) and collection (GET /tests) requests.
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // If the operation is for a collection (e.g., GET /tests)
        if ($operation instanceof CollectionOperationInterface) {
            $testDtos = [];
            $users = $this->userRepository->findAll();

            foreach ($users as $user) {
                $testDtos[] = $this->createDtoFromUser($user);
            }

            return $testDtos;
        }

        // If the operation is for a single item (e.g., GET /test/{id})
        $id = $uriVariables['id'];
        $user = $this->userRepository->find($id);

        // If no user is found for the given ID, throw a 404 exception
        if (!$user) {
            throw new NotFoundHttpException(sprintf('User with ID "%s" not found.', $id));
        }

        return $this->createDtoFromUser($user);
    }

    /**
     * A private helper method to map a User entity to a Test DTO.
     */
    private function createDtoFromUser(User $user): Test
    {
        $dto = new Test();
        $dto->id = $user->getId();
        // Assuming your User entity has getFirstName() and getLastName() methods
        $dto->userFullName = sprintf('%s %s', $user->getFirstName(), $user->getLastName());

        return $dto;
    }
}

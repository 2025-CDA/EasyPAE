<?php

namespace App\State;

use App\Dto\InternDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InternMemberRepository;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\InternMember;

class InternProvider implements ProviderInterface
{
    public function __construct(
        private readonly InternMemberRepository $internMemberRepository,
        private readonly InfoFormRepository $infoFormRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
      
        if ($operation instanceof CollectionOperationInterface) {
            $interns = $this->internMemberRepository->findAll();
            $dtos = [];
            foreach ($interns as $intern) {
                $dto = new InternDTO();
                $dto->id = $intern->getId();
                                $user = $intern->getUser();
                                $dto->firstName = $user?->getFirstName();
                                $dto->lastName = $user?->getLastName();
                                $dto->email = $user?->getEmail();
                      
                $dtos[] = $dto;
            }

            return $dtos;
        }

        if (isset($uriVariables['id'])) {
            $intern = $this->internMemberRepository->find((int)$uriVariables['id']);
            if (!$intern) {
                throw new NotFoundHttpException('Intern member not found.');
            }
            $dto = new InternDTO();
            $dto->id = $intern->getId();
                            $user = $intern->getUser();
                            $dto->firstName = $user?->getFirstName();
                            $dto->lastName = $user?->getLastName();
                            $dto->email = $user?->getEmail();

            return $dto;
        }
    }
}

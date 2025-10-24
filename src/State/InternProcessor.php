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

class InternProcessor implements ProviderInterface
{
    public function __construct(

    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {


    }
}

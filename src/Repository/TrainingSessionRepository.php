<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Entity\TrainingSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingSession>
 */
class TrainingSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingSession::class);
    }

    /**
     * Finds all TrainingSession entities linked to a specific Organization
     * by joining through the OrganizationMember entity.
     *
     * @return TrainingSession[]
     */
    public function findByOrganization(Organization $organization): array
    {
        // We will build a DQL query that looks like:
        // SELECT ts FROM App\Entity\TrainingSession ts
        // JOIN ts.organizationMembers om
        // WHERE om.organization = :org

        return $this->createQueryBuilder('ts') // 'ts' is an alias for TrainingSession
        ->join('ts.organizationMembers', 'om') // 'om' is an alias for OrganizationMember
        ->where('om.organization = :org')
            ->setParameter('org', $organization)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return TrainingSession[] Returns an array of TrainingSession objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TrainingSession
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}

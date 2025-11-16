<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(\Doctrine\Persistence\ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }


    public function persist(object $entity): static
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $this;
    }
}

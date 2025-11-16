<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Seo;

class SeoRepository extends BaseRepository
{
    public function __construct(\Doctrine\Persistence\ManagerRegistry $registry)
    {
        parent::__construct($registry, Seo::class);
    }
}

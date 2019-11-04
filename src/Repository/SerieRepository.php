<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    /**
     * @return Serie[] Returns an array of Serie objects
     */
    
    public function getListNews()
    {
        return $this->createQueryBuilder('serie')
            ->orderBy('serie.premiereDiffusion', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getSerieByDuree($duree)
    {
        return $this->createQueryBuilder('serie')
            ->where('serie.duree < :duree')
            ->setParameter('duree', $duree)
            ->getQuery()
            ->getResult()
        ;
    }
}
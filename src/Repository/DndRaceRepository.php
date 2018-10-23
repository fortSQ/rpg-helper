<?php

namespace App\Repository;

use App\Entity\DndRace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndRace|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndRace|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndRace[]    findAll()
 * @method DndRace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndRaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndRace::class);
    }

//    /**
//     * @return DndRace[] Returns an array of DndRace objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DndRace
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

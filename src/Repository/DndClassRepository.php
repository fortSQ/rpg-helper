<?php

namespace App\Repository;

use App\Entity\DndClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndClass[]    findAll()
 * @method DndClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndClass::class);
    }

//    /**
//     * @return DndClass[] Returns an array of DndClass objects
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
    public function findOneBySomeField($value): ?DndClass
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

<?php

namespace App\Repository;

use App\Entity\DndEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndEquipment[]    findAll()
 * @method DndEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndEquipment::class);
    }

//    /**
//     * @return DndEquipment[] Returns an array of DndEquipment objects
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
    public function findOneBySomeField($value): ?DndEquipment
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

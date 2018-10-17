<?php

namespace App\Repository;

use App\Entity\DndEquipmentSubtype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndEquipmentSubtype|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndEquipmentSubtype|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndEquipmentSubtype[]    findAll()
 * @method DndEquipmentSubtype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndEquipmentSubtypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndEquipmentSubtype::class);
    }

//    /**
//     * @return DndEquipmentSubtype[] Returns an array of DndEquipmentSubtype objects
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
    public function findOneBySomeField($value): ?DndEquipmentSubtype
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

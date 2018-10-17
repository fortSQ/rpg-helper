<?php

namespace App\Repository;

use App\Entity\DndEquipmentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndEquipmentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndEquipmentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndEquipmentType[]    findAll()
 * @method DndEquipmentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndEquipmentTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndEquipmentType::class);
    }

    public function findAllJoinedToDndEquipment()
    {
        return $this->createQueryBuilder('et')
            // p.category refers to the "category" property on product
            ->innerJoin('et.dndEquipment', 'e')
            // selects all the category data to avoid the query
            ->addSelect('e')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return DndEquipmentType[] Returns an array of DndEquipmentType objects
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
    public function findOneBySomeField($value): ?DndEquipmentType
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

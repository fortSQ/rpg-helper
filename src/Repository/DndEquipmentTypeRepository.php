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

    /**
     * @param null|string $term
     * @return DndEquipmentType[]
     */
    public function findAllWithSubtypesAndEquipments(?string $term)
    {
        $qb = $this->createQueryBuilder('et')
            ->leftJoin('et.equipments', 'ete')
            ->leftJoin('et.subtypes', 'es')
            ->leftJoin('es.equipments', 'e')
            ->addSelect('ete')
            ->addSelect('e')
            ->addSelect('es')
        ;

        if ($term) {
            $qb->andWhere('
                    e.name LIKE :term OR
                    e.properties LIKE :term OR
                    e.damage_type LIKE :term OR
                    et.name LIKE :term OR
                    es.name LIKE :term
                ')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb->getQuery()
            ->getResult(2);
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

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

    /**
     * @param null|string $term
     * @return DndEquipment[]
     */
    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.type', 't')
            ->leftJoin('t.subtypes', 'ts')
            ->leftJoin('e.subtype', 's')
            ->addSelect('t')
            ->addSelect('ts')
            ->addSelect('s')
        ;

        if ($term) {
            $qb->andWhere('
                    e.name LIKE :term OR
                    e.properties LIKE :term OR
                    e.damage_type LIKE :term OR
                    t.name LIKE :term OR
                    s.name LIKE :term
                ')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb->getQuery()
            ->getResult();
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

<?php

namespace App\Repository;

use App\Entity\DndCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DndCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method DndCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method DndCharacter[]    findAll()
 * @method DndCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DndCharacterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DndCharacter::class);
    }

//    /**
//     * @return DndCharacter[] Returns an array of DndCharacter objects
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
    public function findOneBySomeField($value): ?DndCharacter
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

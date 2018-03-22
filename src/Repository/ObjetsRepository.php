<?php

namespace App\Repository;

use App\Entity\Objets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Objets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objets[]    findAll()
 * @method Objets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Objets::class);
    }

//    /**
//     * @return Objets[] Returns an array of Objets objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objets
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

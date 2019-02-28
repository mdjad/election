<?php

namespace App\Repository;

use App\Entity\Electeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Electeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Electeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Electeur[]    findAll()
 * @method Electeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElecteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Electeur::class);
    }

    // /**
    //  * @return Electeur[] Returns an array of Electeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Electeur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

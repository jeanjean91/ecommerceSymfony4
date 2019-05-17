<?php

namespace App\Repository;

use App\Entity\Commandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commandes::class);
    }

     /**
      * @return Commandes[] Returns an array of Commandes objects
      */

    public function findByCommandeCli($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.client= :client')
            ->setParameter('client', $id)
           /* ->orderBy('c.id', 'ASC')*/
            ->setMaxResults(1000)
            ->getQuery()
          /*  ->getResult()*/
        ;
    }


    /*
    public function findOneBySomeField($value): ?Commandes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

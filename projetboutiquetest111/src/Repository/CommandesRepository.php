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



    public function findByCommandeCli($userId):array
    {
        $connect =$this->createQueryBuilder('c')
            ->andWhere('c.client = :client')
            ->setParameter('client', $userId)
           /* ->orderBy('e.date', 'DESC')*/
            ->setMaxResults(38)
            ->getQuery()
            /* ->getResult()*/
        ;
        return $connect ->execute();
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

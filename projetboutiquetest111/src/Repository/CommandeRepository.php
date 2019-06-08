<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
   /* public function findByCommandeCli($id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.commande.client= :commande.client')
            ->setParameter('commande.client', $id)*/
            /* ->orderBy('c.id', 'ASC')*/
           /* ->setMaxResults(1000)
            ->getQuery()*/
            /*  ->getResult()*/
      /*      ;
    }*/
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

}

<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

     /**
     * @return Produit[] Returns an array of Produit objects
     */

    public function findByExampleField($avent):array
    {
       $connect =$this->createQueryBuilder('p')
            ->andWhere('p.enAvant = :enAvant')
            ->setParameter('enAvant', $avent)
           /* ->orderBy('p.id', 'ASC')*/
            ->setMaxResults(10)
            ->getQuery()
          /* ->getResult()*/
        ;
            return $connect ->execute();
    }
    public function findByenSOLDE($solde):array
    {
        $connect =$this->createQueryBuilder('p')
            ->andWhere('p.enSolde = :enSolde')
            ->setParameter('enSolde', $solde)
            /* ->orderBy('p.id', 'ASC')*/
            ->setMaxResults(7)
            ->getQuery()
            /* ->getResult()*/
        ;
        return $connect ->execute();
    }
   /* public function findAllGreaterThanPrice(ProduitRepository $repository,
                                            objectManager $manager): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM produit
        WHERE en_solde = 1

        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['price' => $repository]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }*/

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

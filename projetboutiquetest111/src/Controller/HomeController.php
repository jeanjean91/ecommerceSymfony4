<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\DetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use App\Entity\Client;


use App\Repository\ProduitRepository;

use phpDocumentor\Reflection\DocBlock\Description;


use App\Entity\User;

use App\Form\ProuitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;

use App\Entity\Commande;
use App\Entity\Detail;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Produit;
use App\Form\UserType;
use App\Repository\CommandesRepository;
use App\Entity\Registration;

class HomeController extends AbstractController
{

    public function index(){

        return $this->render("home/index.html.twig");

    }

    /**
     * @Route("/base.html.twig", name="base")
     */
    public function cat(CategorieRepository $categorieRepository){

        $Cat = $categorieRepository-> findCatFirstLevel();


        return $this->render("base.html.twig", [

            'Cat' => $Cat
        ]);


    }



    public function add($id, Request $request, ProduitRepository $repository, ObjectManager $manager)
    {
        $session = $request->getSession();
        if(!$session->get('panier'))
        {
            $panier = $session->set('panier', array());
        }
        $panier = $session->get('panier');

        if(isset($panier[$id]))
        {
            $panier[$id] += 1;
        }
        else
        {
            $panier[$id] = 1;
        }
        //$produits = $repository->findArrayById( arrays_keys($panier) );
        $commande = new Commande();
        $client = $this->getUser();
        $commande->setClient($client);
        $commande->setDate(new \DateTime());
        foreach ( $panier as $key => $value)
        {
            $detail = new Detail();
            $produit = $repository->findOneBy( ['id' => $key] );
            $detail->setCommande($commande);
            $detail->setProduit($produit);
            $detail->setQte($value);
            $details[] = $detail;
        }
        $session->set('panier', $panier);
        /*dump($panier);*/
        return $this->render('home/espace.html.twig', [
            'details' => $details,
        ]);

    }
  /*  public function menu(CategorieRepository $repository, ObjectManager $manager): Response
    {
        $Cat = $repository->findCatFirstLevel();

        return $this->render('home/index2.html.twig', [
            'Cat' => $Cat
        ]);
    }*/


    /**
* @Route("/home-espace", name="home.espace")
*/
    public function commandes(/*$id,*/UserRepository  $query, CommandeRepository $repository,
                               objectManager $manager,Request $request, PaginatorInterface $paginator)
    {
/*
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $commandesRepository = $em->getRepository(Commande::class);

        // Find all the data on the Appointments table, filter your query as you need
        $allAppointmentsQuery = $commandesRepository->createQueryBuilder('p')
            ->where('client_d == :user.id')
            ->setParameter('user.id', 'canceled')
            ->getQuery();*/

        /*$query = $manager->createQuery(  "SELECT * FROM App\Entity\Commande
                                        
                                        WHERE );*/

       /* $commandes = $repository->findAll();*/
        /*$commandes = $paginator->paginate(
        // Doctrine Query, not results
            $allAppointmentsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );*/


/*
       $user = $this->get('security.token_storage')->getToken()->getUser();
        $usersid = $user ;

        $detail =$this->getDoctrine()
            ->getRepository(Detail::class)
            ->findByCommandeCli($usersid );

*/

        /*return $this->render('home/espace.html.twig', [
            'detail' => $detail
        ]);*/
    }
    /**
     * @Route("/home-espace", name="home.espace")
     */
    public function detail( UserRepository  $query,DetailRepository $repository,CommandeRepository $commandeRepository,
    objectManager $manager)
    {





        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid = $user ;

/*
      $detail= $repository->findAll(   $userid );*/
       $detail =$this->getDoctrine()
                 ->getRepository( Detail::class)
                 ->findByDetailCli($userid);
       $commande = $commandeRepository ->findByCommandeCli($userid);
        return $this->render('home/espace.html.twig', [
            'detail' => $detail,
           'commandes' => $commande
        ]);
    }

    /**
     * @Route("/home-index2", name="home.index2")
     */
    public function index3(ProduitRepository $repository,
                           objectManager $manager,CategorieRepository $categorieRepository)
    {


        $nombreSolde =1;

        $produits =$this->getDoctrine()
            ->getRepository(produit::class)
            ->findByenSOLDE($nombreSolde);


        $Cat = $categorieRepository->findCatFirstLevel();

        return $this->render('home/index2.html.twig', [
            'produit' => $produits,
            'Cat' => $Cat
        ]);

        $nombreProd =1;


        $produits =$this->getDoctrine()
            ->getRepository(produit::class)
            ->findByExampleField($nombreProd);

        return $this->render('home/index2.html.twig', [
            'produit' => $produits
        ]);
    }

}

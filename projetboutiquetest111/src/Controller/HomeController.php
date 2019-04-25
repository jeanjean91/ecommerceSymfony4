<?php

namespace App\Controller;


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

use App\Entity\Produit;
class HomeController extends AbstractController
{

    public function index(){

        return $this->render("home/index.html.twig");

    }


    /**
     * @Route("/home-index2", name="home.index2")
     */
    public function index2(ProduitRepository $repository,
                           objectManager $manager){

        $produits = $repository->findAll();

        return $this->render("home/index2.html.twig",[
        'produit' => $produits
        ]);

    }
    /**
     * @Route("/home-espace", name="home.espace")
     */
    public function espaceUser(){

        return $this->render("home/espace.html.twig");

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
    /**
     * @Route("/home-index2", name="home.index2")
     */
    public function index3(ProduitRepository $repository,
                          objectManager $manager)
    {

        /*$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCPlatformBundle:enAvant');*/
        $produits = $repository->findAll();
        return $this->render('home/index2.html.twig', [
            'produit' => $produits
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\ProduitRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier-affiche-{id<\d+>}", name="panier.affiche")
     */
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
        return $this->render('panier/index.html.twig', [
            'details' => $details,
        ]);
    }
    /**
     * @Route("/panier/produit/{id<\d+>}/delete", name="panier.produit.delete")
     */

    public function delete(Produit $produit, ObjectManager $manager )
    {
        //dump("suppression");
        $manager->remove($produit);
        $manager->flush();
        $this->addFlash('success',"bien supprimé !");
        //return new Response("Suppression");
        return $this->redirectToRoute('panier.index');

    }
    /**
     * @Route("/panier", name="panier.index")
     */
    public function vue(){

        return $this->render("panier/index.html.twig");

    }


}


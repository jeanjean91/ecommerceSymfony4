<?php

namespace App\Controller;

use App\Repository\ProduitRepository;

use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ProuitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProduitType;
use App\Controller\CategorieRepository;

use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Commande;
use App\Entity\Detail;





class ProduitController extends AbstractController
{

    //affichage produits de la boutique sans contrainte
    /**
     * @Route("/produits", name="produits")
     */
    public function produits(ProduitRepository $repository,
                          objectManager $manager,Request $request, PaginatorInterface $paginator,\App\Repository\CategorieRepository $categorieRepository)
    {
       /* $produit = $repository->findOneBy(array('id' => 1) );*/
        $allproduits = $repository->findAll();
        $produit = $paginator->paginate(
        // Doctrine Query, not results
            $allproduits,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            9
        );
        $Cat = $categorieRepository-> findCatFirstLevel();

        return $this->render('produit/Catprod.html.twig', [
            'produits' => $produit,
            'Cat' => $Cat
        ]);
    }

   //ajouter un produits

    /**
     * @Route("/produit/add", name="produit.add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $produit = new Produit();
        /*$produit->setLibelle("pi");
        $produit->setPoids();*/
        $form = $this->createForm(ProuitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute("admin");
        }
        /*dump($produit);*/

        return $this->render('produit/add.html.twig', [
            'formProduit' => $form->createView()
        ]);
    }
        //afficher deatil du produit
  /**
     * @Route("/produit-show-{id}", name="produit")
     */
    public function show($id, ProduitRepository $repository)
    {
        $produit = $repository->findOneBy(['id' => $id]);

        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }


    //mmetre a jour le produit
    /**
     * @Route("/produit/{id}/update", name="produit.update")
     */
    public function update($id, ProduitRepository $repository,Request $request, ObjectManager $manager)
    {

        $produit = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(ProuitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute("admin");

        }

        return $this->render('produit/update.html.twig', [
            'formProduit' => $form->createView()
        ]);
    }

    //afficher une categorie
    /**
     * @Route("/produit-{idCat}", name="produitsParCat")
     */
    public function prod(ProduitRepository $repository, \App\Repository\CategorieRepository $categorieRepository, ObjectManager $manager, Request $request, PaginatorInterface $paginator, $idCat)
    {
        $query = $manager->createQuery(  "SELECT DISTINCT p FROM App\Entity\Produit p
                                        JOIN p.categorie cn3 JOIN cn3.categorie cn2 JOIN cn2.categorie cn1
                                        WHERE cn3.id= :id3 OR  cn2.id= :id2 OR  cn1.id= :id1 ORDER BY p.libelle ASC");
        $query->setParameters(array('id1' => $idCat, 'id2' => $idCat, 'id3' => $idCat));

        //$paginator = $this->get('knp_paginator');
        $produit = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            12
        );
        $Cat = $categorieRepository-> findCatFirstLevel();

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
            'Cat' => $Cat
        ]);
    }

}

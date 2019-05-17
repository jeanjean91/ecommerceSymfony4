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
    /**
     * @Route("/produits", name="produits")
     */
    public function index(ProduitRepository $repository,
                          objectManager $manager,Request $request, PaginatorInterface $paginator)
    {
        $produit = $repository->findOneBy(array('id' => 1) );
        $allproduits = $repository->findAll();
        $produits = $paginator->paginate(
        // Doctrine Query, not results
            $allproduits,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            9
        );

        return $this->render('produit/Catprod.html.twig', [
            'produits' => $produits
        ]);
    }
    /*public function menu(\App\Repository\CategorieRepository $repository, ObjectManager $manager): Response
    {
        $listCategories = $repository->findCatFirstLevel();

        return $this->render('produit/Catprod.html.twig', [
            'listCategorie' => $listCategories
        ]);
    }*/




    /*public function menu(CategorieRepository $repository, ObjectManager $manager): Response
    {
        $listCat = $repository->findCatFirstLevel();

        return $this->render('produit/Catprod.html.twig', [
            'listCat' => $listCat
        ]);
    }*/
    public function menu(\App\Repository\CategorieRepository $repository, ObjectManager $manager): Response
    {
        $listCats = $repository->findCatFirstLevel();

        return $this->render('produit/Catprod.html.twig', [
            'listCat' => $listCats
        ]);
    }

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
    /**
     * @Route("/produits-{idCat}", name="produitsParCat")
     */
    public function produits(ProduitRepository $repository, \App\Repository\CategorieRepository $categorieRepository, ObjectManager $manager, Request $request, PaginatorInterface $paginator, $idCat)
    {
        $query = $manager->createQuery(  "SELECT DISTINCT p FROM App\Entity\Produit p
                                        JOIN p.categorie cn3 JOIN cn3.categorie cn2 JOIN cn2.categorie cn1
                                        WHERE cn3.id= :id3 OR  cn2.id= :id2 OR  cn1.id= :id1 ORDER BY p.libelle ASC");
        $query->setParameters(array('id1' => $idCat, 'id2' => $idCat, 'id3' => $idCat));

        //$paginator = $this->get('knp_paginator');
        $produits = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            12/*nbre d'éléments par page*/
        );

        return $this->render('produit/index.html.twig', [
            'produit' => $produits,
        ]);
    }

}

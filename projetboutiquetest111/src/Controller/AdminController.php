<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Form\CategoriesType;
use App\Form\FournisseurType;
use App\Form\UserType;
use App\Repository\CommandesRepository;
use App\Repository\DetailRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use phpDocumentor\Reflection\DocBlock\Description;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ProuitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Entity\Client;
use App\Form\RegistrationFormType;
use App\Entity\Registration;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index( ProduitRepository $repository,
                           objectManager $manager,Request $request, PaginatorInterface $paginator)
    {



        $allproduits = $repository->findAll();
        $produits = $paginator->paginate(
        // Doctrine Query, not results
            $allproduits,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            7
        );


        return $this->render('admin/produits.html.twig', [
            'produits' => $produits
        ]);
    }


    // afficher les commandes

    /**
    * @Route("/admin/commandes", name="admin.commandes")
    */
    public function commandes( CommandeRepository $repository,
                           objectManager $manager,Request $request, PaginatorInterface $paginator)
    {



        $allcommandes = $repository->findAll();

        $commandes = $paginator->paginate(
        // Doctrine Query, not results
            $allcommandes,


            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );




        return $this->render('admin/commandes.html.twig', [
            'commandes' => $commandes
        ]);
    }
    //afficher les categories
    /**
     * @Route("/admin-categories", name="admin.categories")
     */

    public function categories(\App\Repository\CategorieRepository $categorieRepository){



        $Cat = $categorieRepository-> findCatFirstLevel();

        return $this->render('admin/categories.html.twig', [
            'Cat' => $Cat
        ]);
    }

    // afficher les souscategories
    /**
     * @Route("/admin-souscategories", name="admin.souscategories")
     */

    public function souscategories(\App\Repository\CategorieRepository $categorieRepository){



        $Cat = $categorieRepository-> findCatFirstLevel();

        return $this->render('admin/souscategories.html.twig', [
            'Cat' => $Cat
        ]);
    }

    //ajouter une categorie
    /**
     * @Route("/admin-AddCategorie", name="admin.AddCategorie")
     */

    public function addCat(Request $request, ObjectManager $manager)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/AddCategorie.html.twig', [
            'formCat' => $form->createView()
        ]);
    }
    //ajouter un fournisseur
    /**
     * @Route("/admin-AddFournisseur", name="admin.AddFournisseur")
     */

    public function addFournisseur(Request $request, ObjectManager $manager)
    {
        $fournisseur = new Fournisseur();

        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($fournisseur);
            $manager->flush();
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/AddFournisseur.html.twig', [
            'formFournisseur' => $form->createView()
        ]);
    }



    //afficher les details

    /**
     * @Route("/admin/detail", name="admin.detail")
     */
    public function detail( DetailRepository $repository,
                               objectManager $manager,Request $request, PaginatorInterface $paginator)
    {



        $alldetails = $repository->findAll();

        $details = $paginator->paginate(
        // Doctrine Query, not results
            $alldetails,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );

        return $this->render('admin/detail.html.twig', [
            'detail' => $details
        ]);
    }

    //afficher les utilisateur
    /**
     * @Route("/admin/user", name="admin.user")
     */
    public function user( UserRepository $repository,
                          objectManager $manager,Request $request, PaginatorInterface $paginator)
    {




        $allusers = $repository->findAll();
        $users = $paginator->paginate(
        // Doctrine Query, not results
            $allusers,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            7
        );



        return $this->render('admin/user.html.twig', [
            'users' => $users
        ]);
    }

    //afficher les produits
    /**
     * @Route("/admin/liste/{id}", name="admin.produit.liste")
     */
    public function liste($id, ProduitRepository $repository,Request $request, ObjectManager $manager)
    {
        $produit = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();
            return $this->redirectToRoute("admin");

        }
        return $this->render('admin/liste.html.twig', [
            'formProduit' => $form->createView()
        ]);
    }

    //ajouter un utilisateur
    /**
     * @Route("/admin-userAdd", name="admin.userAdd")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $user = new user();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/userAdd.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    // mettre a jour les utilisateur
    /**
     * @Route("/admin/{id}/update", name="admin.update")
     */
    public function update($id, ProduitRepository $repository,Request $request, ObjectManager $manager)
    {

        $user = $repository->findOneBy(['id' => $id]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("admin");

        }

        return $this->render('admin/update.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    // suprimer un produit
    /**
     * @Route("admin/produit/{id}", name="admin.produit.delete")
     */
    public function delete(Produit  $produit, ObjectManager $manager)
    {

        $manager->remove($produit);
        $manager->flush();
        return $this->redirectToRoute("admin");


    }


    //suprimer un compte utilisateur
    /**
     * @Route("admin/user/{id}", name="admin.user.delete")
     */
    public function delete1(User  $user, ObjectManager $manager)
    {

        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute("admin.user");


    }

}


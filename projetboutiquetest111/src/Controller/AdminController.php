<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\CommandesRepository;
use App\Repository\DetailRepository;
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
                           objectManager $manager)
    {



        $produits = $repository->findAll();



        return $this->render('admin/produits.html.twig', [
            'produits' => $produits
        ]);
    }
    /**
 * @Route("/admin/commandes", name="admin.commandes")
 */
    public function commandes( CommandeRepository $repository,
                           objectManager $manager)
    {



        $commandes = $repository->findAll();



        return $this->render('admin/commandes.html.twig', [
            'commandes' => $commandes
        ]);
    }
    /**
     * @Route("/admin/detail", name="admin.detail")
     */
    public function detail( DetailRepository $repository,
                               objectManager $manager)
    {



        $details = $repository->findAll();



        return $this->render('admin/detail.html.twig', [
            'detail' => $details
        ]);
    }
    /**
     * @Route("/admin/user", name="admin.user")
     */
    public function user( UserRepository $repository,
                          objectManager $manager)
    {



        $users = $repository->findAll();



        return $this->render('admin/user.html.twig', [
            'users' => $users
        ]);
    }
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
    /**
     * @Route("/admin/userAdd", name="admin.userAdd")
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
    /**
     * @Route("admin/produit/{id}", name="admin.produit.delete")
     */
    public function delete(Produit  $produit, ObjectManager $manager)
    {

        $manager->remove($produit);
        $manager->flush();
        return $this->redirectToRoute("admin");


    }
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


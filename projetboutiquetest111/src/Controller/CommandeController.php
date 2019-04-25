<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\This;
use App\Entity\Commande;
use App\Entity\Detail;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;

use App\Entity\Produit;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commande-validation", name="commande.validation")
     */
    public function index(Request $request,ProduitRepository $repository,ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $session = $request->getSession();
        $panier=$session->get('panier');

        $commande=new Commande();
        $commande->setDate(new \DateTime());
        $client=$this->getUser();
        $commande->setClient($client);
        $manager->persist($commande);

        foreach ($panier as $key=>$value){
            $detail =new Detail();
            $produit = $repository->findOneBy(['id'=>$key]);
            $detail->setCommande($commande);
            $detail->setProduit($produit);
            $detail->setqte($value);

            $manager->persist($detail);
            $manager->flush();

            $session->set('panier',array());
            return $this->render('commande/validation.html.twig')

           ;}
    }


       /* return $this->render('commande/affiche.html.twig', [
            'controler_name'=>'commandeController',

        ]);*/

    /**
     * @Route("/email", name="admin.email")
     */
    public function email(\Swift_Mailer $mailer)

    {
        $client= $this->getUser();
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('jeandesir73@gmail.com')
            ->setTo($client->getEmail)
            ->setBody(
                $this->renderView(
                // templates/email/registration.html.twig
                    'email/confirmCommande.html.twig',
                    ['client' => $client]
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'email/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);

        return $this->render(...commandes/validation.html.twig);
    }


}

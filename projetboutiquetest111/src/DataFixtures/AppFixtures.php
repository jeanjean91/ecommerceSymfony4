<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Produit;
use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Image;
use App\Entity\Categorie;
use Doctrine\Common\Collections\ArrayCollection;



class AppFixtures extends Fixture
{

private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
{         $this->passwordEncoder = $passwordEncoder;
}

    public function load(ObjectManager $manager){
        $faker = \Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setEmail("jeandesir73@gmail.com");
        $user->setuser("$faker->name");
        $user->setAdress("$faker->address");
        $user->setLocalite("$faker->city");
        $user->setCompte("$faker->randomDigit");
        $user->setCat("$faker->randomDigit");

        $manager->persist($user);
        $manager->flush();

        $faker = \Faker\Factory::create('fr_FR');
        $b = mt_rand(5,100);
        for ($j=0; $j<$b;$j++) {

            $user = new User();
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            $user->setEmail("$faker->email");
            $user->setUser("$faker->name");
            $user->setAdress("$faker->address");
            $user->setLocalite("$faker->city");
            $user->setCompte("$faker->randomDigit");
            $user->setCat("$faker->randomDigit");

            $manager->persist($user);
            $manager->flush();
        }
        // ...

        $faker = \Faker\Factory::create();

        $catNiv1 = new ArrayCollection();
        $catNiv2 = new ArrayCollection();
        $catNiv3 = new ArrayCollection();


        for ($i = 0; $i < 30; $i++)
        {
            $cat = new Categorie();
            $cat->setNom('Catégorie ' . $faker->word)
                ->setDescription('Catégorie ' . $faker->text)
                ->setNiveau($i)
                ->setCategorie($cat);

            $manager->persist($cat);
            $catNiv1->add($cat);
        }

        $j = 0;
        for ($i = 0; $i < 25; $i++)
        {
            if($j == 30){ $j = 0; }
            $cat = new Categorie();
            $cat->setNom('Sous Catégorie ' . $faker->word)
                ->setDescription('Sous Catégorie ' . $faker->text)
                ->setNiveau($i)
                ->setCategorie($catNiv1->get($j));

            $manager->persist($cat);
            $catNiv2->add($cat);
            $j++;
        }

        $j = 0;
        for ($i = 0; $i < 125; $i++)
        {
            if($j == 25){ $j = 0; }
            $cat = new Categorie();
            $cat->setNom('Sous Sous Catégorie ' . $faker->word)
                ->setDescription('Sous Sous Catégorie ' . $faker->text)
                ->setNiveau($i)
                ->setCategorie($catNiv2->get($j));

            $manager->persist($cat);
            $catNiv3->add($cat);
            $j++;
        }

        $N=random_int(1,100);
        for($i=0;$i<$N;$i++){
            /*'<p>'.joint($faker->)*/
        /*$x=random_int(1,5);*/
            $x=random_int(1,5);
            $y=random_int(5,10);
            $z=random_int(10,15);
            $dim=$x."x".$y."x".$z;

        $produit =new Produit();

        $produit->setImage($faker->imageURL($width = 640, $height = 480));
        $produit->setLibelle($faker->word);
        $produit->setDimentions($dim);
        $produit->setDescription($faker->text);
        $produit->setPrix($faker->randomDigit);
        $produit->setPoids($faker->randomDigit);
        $produit->setText($faker->word);
        $produit->setEnSolde($faker->randomDigit);
        $produit->setEnAvant($faker->randomDigit);
        $produit->setCodeBarre($faker->randomDigit);
        $produit->setCodeFournisseur($faker->randomDigit);
        $produit->setConditionnement($faker->randomDigit);
        $produit->setTaille($faker->randomDigit);
        $produit->setPrixAchat($faker->randomDigit);
        $produit->setTva($faker->randomDigit);
        $produit->setCategorie($catNiv3->get($j));





            $manager->persist($produit);
        $manager->flush();
/*
        $manager->flush();
            $user =new Client();

            $user->setNom($faker->name);
            $user->setAdress($faker->secondaryAddress );
            $user->setLocalite($faker->word);
            $user->setLocalite($faker->word);
            $user->setCat($faker->randomLetter.$faker->randomDigit);
            $user->setCompte($faker->randomDigit);


            $manager->persist($user);
            $manager->flush();

            $manager->flush();*/
        }
    }


}

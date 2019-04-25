<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Cat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNcli(): ?string
    {
        return $this->Ncli;
    }

    public function setNcli(string $Ncli): self
    {
        $this->Ncli = $Ncli;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getCat(): ?string
    {
        return $this->Cat;
    }

    public function setCat(string $Cat): self
    {
        $this->Cat = $Cat;

        return $this;
    }

    public function getCompte(): ?string
    {
        return $this->Compte;
    }

    public function setCompte(string $Compte): self
    {
        $this->Compte = $Compte;

        return $this;
    }
}

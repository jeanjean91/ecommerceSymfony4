<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $enSolde;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enAvant;
    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeBarre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeFournisseur;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $taille;

    /**
     * @ORM\Column(type="integer", nullable=true, nullable=true)
     */
    private $conditionnement;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $prixAchat;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2, nullable=true)
     */
    private $tva;

    /**
     * @ORM\Column(type="boolean", nullable=true, nullable=true)
     */
    private $enVente;


    /**
     * @ORM\Column(type="integer", nullable=true, nullable=true)
     */
    private $qstock;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $dimentions;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="produit", orphanRemoval=true)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="produits")
     */
    private $commande;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getEnSolde(): ?bool
    {
        return $this->enSolde;
    }

    public function setEnSolde(bool $enSolde): self
    {
        $this->enSolde = $enSolde;

        return $this;
    }

    public function getEnAvant(): ?bool
    {
        return $this->enAvant;
    }

    public function setEnAvant(bool $enAvant): self
    {
        $this->enAvant = $enAvant;

        return $this;
    }

    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->codeBarre;
    }

    public function setCodeBarre(string $codeBarre): self
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    public function getCodeFournisseur(): ?string
    {
        return $this->codeFournisseur;
    }

    public function setCodeFournisseur(string $codeFournisseur): self
    {
        $this->codeFournisseur = $codeFournisseur;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getConditionnement(): ?string
    {
        return $this->conditionnement;
    }

    public function setConditionnement(string $conditionnement): self
    {
        $this->conditionnement = $conditionnement;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(int $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getTva()
    {
        return $this->tva;
    }

    public function setTva($tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getEnVente(): ?bool
    {
        return $this->enVente;
    }

    public function setEnVente(?bool $enVente): self
    {
        $this->enVente = $enVente;

        return $this;
    }

    public function getQstock(): ?int
    {
        return $this->qstock;
    }

    public function setQstock(?int $qstock): self
    {
        $this->qstock = $qstock;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDimentions(): ?string
    {
        return $this->dimentions;
    }

    public function setDimentions(?string $dimentions): self
    {
        $this->dimentions = $dimentions;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setProduit($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getProduit() === $this) {
                $detail->setProduit(null);
            }
        }

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}

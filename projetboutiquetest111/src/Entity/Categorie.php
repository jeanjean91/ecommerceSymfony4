<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository",)
 */
class Categorie
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
    private $nom;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="categorie")
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $sousCategories;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="sousCategorie")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="categorie")
     */
    private $produits;

    public function __construct() {
        $this->sousCategories = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Add sousCategory.
     *
     * @param Categorie $sousCategory
     *
     * @return Categorie
     */
    public function addSousCategory(Categorie $sousCategory)
    {
        $this->sousCategories[] = $sousCategory;
        $sousCategory->setCategorie($this);

        return $this;
    }

    /**
     * Remove sousCategory.
     *
     * @param Categorie $sousCategory
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSousCategory(Categorie $sousCategory)
    {
        return $this->sousCategories->removeElement($sousCategory);
    }

    /**
     * Get sousCategories.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSousCategories()
    {
        return $this->sousCategories;
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

    /**
     * Add sousCategory.
     *
     * @param Categorie $produit
     *
     * @return Categorie
     */
    public function addProduits(Produit $produit)
    {
        $this->produits[] = $produit;
        $produit->setCategorie($this);

        return $this;
    }

    /**
     * Remove sousCategory.
     *
     * @param Categorie $sousCategory
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProduits(Produit $produit)
    {
        return $this->produits->removeElement($produit);
    }

    /**
     * Get sousCategories.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * @return nom
     */
    public function __toString(): string
    {
        return $this->nom;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $fournisseur_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseurId(): ?int
    {
        return $this->fournisseur_id;
    }

    public function setFournisseurId(int $fournisseur_id): self
    {
        $this->fournisseur_id = $fournisseur_id;

        return $this;
    }
}

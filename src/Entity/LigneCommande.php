<?php

namespace App\Entity;

use App\Repository\LigneCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneCommandeRepository::class)
 */
class LigneCommande
{
    // convertir en string - pour corriger l'erreur Symfony : https://ourcodeworld.com/articles/read/1460/how-to-fix-symfony-5-error-object-of-class-proxies-cg-appentity-could-not-be-converted-to-string 
    public function __toString()
    {
        // return $this->produit;
        // return $this->commande;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="ligneCommandes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="lignes_commande")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

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

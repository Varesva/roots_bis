<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    // convertir en string - pour corriger l'erreur Symfony : https://ourcodeworld.com/articles/read/1460/how-to-fix-symfony-5-error-object-of-class-proxies-cg-appentity-could-not-be-converted-to-string 
    public function __toString()
    {
        return $this->titre;
        // return $this->livre_auteur;
        // return $this->livre_edition;
        // return $this->livre_resume;
        // return $this->livre_resume;
        // return $this->livre_resume;
    }
    // fin conversion en string

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $giftcard_valeur;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $livre_auteur;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $livre_edition;

    /**
     * @ORM\Column(type="string", length=800, nullable=true)
     */
    private $livre_resume;

    /**
     * @ORM\ManyToOne(targetEntity=Nutrition::class, inversedBy="produits")
     */
    private $categ_nutrition;

    /**
     * @ORM\ManyToOne(targetEntity=Boutique::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $categ_produit;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieRestaurant::class, inversedBy="produits")
     */
    private $categ_type_cuisine;

    /**
     * @ORM\OneToMany(targetEntity=LigneCommande::class, mappedBy="produit")
     */
    private $ligneCommandes;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getGiftcardValeur(): ?int
    {
        return $this->giftcard_valeur;
    }

    public function setGiftcardValeur(?int $giftcard_valeur): self
    {
        $this->giftcard_valeur = $giftcard_valeur;

        return $this;
    }

    public function getLivreAuteur(): ?string
    {
        return $this->livre_auteur;
    }

    public function setLivreAuteur(?string $livre_auteur): self
    {
        $this->livre_auteur = $livre_auteur;

        return $this;
    }

    public function getLivreEdition(): ?string
    {
        return $this->livre_edition;
    }

    public function setLivreEdition(?string $livre_edition): self
    {
        $this->livre_edition = $livre_edition;

        return $this;
    }

    public function getLivreResume(): ?string
    {
        return $this->livre_resume;
    }

    public function setLivreResume(?string $livre_resume): self
    {
        $this->livre_resume = $livre_resume;

        return $this;
    }

    public function getCategNutrition(): ?Nutrition
    {
        return $this->categ_nutrition;
    }

    public function setCategNutrition(?Nutrition $categ_nutrition): self
    {
        $this->categ_nutrition = $categ_nutrition;

        return $this;
    }

    public function getCategProduit(): ?Boutique
    {
        return $this->categ_produit;
    }

    public function setCategProduit(?Boutique $categ_produit): self
    {
        $this->categ_produit = $categ_produit;

        return $this;
    }

    public function getCategTypeCuisine(): ?CategorieRestaurant
    {
        return $this->categ_type_cuisine;
    }

    public function setCategTypeCuisine(?CategorieRestaurant $categ_type_cuisine): self
    {
        $this->categ_type_cuisine = $categ_type_cuisine;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }
}

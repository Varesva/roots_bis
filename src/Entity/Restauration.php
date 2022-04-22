<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurationRepository::class)
 */
class Restauration
{
    // convertir en string - pour corriger l'erreur Symfony : https://ourcodeworld.com/articles/read/1460/how-to-fix-symfony-5-error-object-of-class-proxies-cg-appentity-could-not-be-converted-to-string 
    public function __toString()
    {
        return $this->type_cuisine;
    }
    // fin conversion en string

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $type_cuisine;

    /**
     * @ORM\OneToMany(targetEntity=Restaurant::class, mappedBy="restauration")
     */
    private $restaurants;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="categ_restauration")
     */
    private $produits;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCuisine(): ?string
    {
        return $this->type_cuisine;
    }

    public function setTypeCuisine(string $type_cuisine): self
    {
        $this->type_cuisine = $type_cuisine;

        return $this;
    }

    /**
     * @return Collection<int, Restaurant>
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setRestauration($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurants->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getRestauration() === $this) {
                $restaurant->setRestauration(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategRestauration($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategRestauration() === $this) {
                $produit->setCategRestauration(null);
            }
        }

        return $this;
    }
}

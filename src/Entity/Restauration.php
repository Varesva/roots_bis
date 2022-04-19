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
     * @ORM\OneToMany(targetEntity=Livre::class, mappedBy="restauration")
     */
    private $livres;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
        $this->livres = new ArrayCollection();
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
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
            $livre->setRestauration($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getRestauration() === $this) {
                $livre->setRestauration(null);
            }
        }

        return $this;
    }
}

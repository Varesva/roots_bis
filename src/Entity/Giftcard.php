<?php

namespace App\Entity;

use App\Repository\GiftcardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GiftcardRepository::class)
 */
class Giftcard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $carte;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $valeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarte(): ?string
    {
        return $this->carte;
    }

    public function setCarte(string $carte): self
    {
        $this->carte = $carte;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}

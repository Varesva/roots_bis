<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $num_commande;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $prix_ttc;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandes")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $liste_produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCommande(): ?string
    {
        return $this->num_commande;
    }

    public function setNumCommande(string $num_commande): self
    {
        $this->num_commande = $num_commande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getPrixTtc(): ?string
    {
        return $this->prix_ttc;
    }

    public function setPrixTtc(string $prix_ttc): self
    {
        $this->prix_ttc = $prix_ttc;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getListeProduit(): ?string
    {
        return $this->liste_produit;
    }

    public function setListeProduit(string $liste_produit): self
    {
        $this->liste_produit = $liste_produit;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementsRepository")
 */
class Evenements
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="bigint")
     */
    private $quantite;

    /**
     * @ORM\Column(type="bigint")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tva", inversedBy="fkEvenementTva", cascade={"remove"})
     */
    private $fkTva;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarif", inversedBy="fkEvenementTarif", cascade={"remove"})
     */
    private $fkTarif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clients", inversedBy="fkEvenementClient", cascade={"remove"})
     */
    private $fkClient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="fkEvenement", cascade={"remove"})
     */
    private $fkEntreprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getFkTva()
    {
        return $this->fkTva;
    }

    public function setFkTva(?Tva $fkTva): self
    {
        $this->fkTva = $fkTva;

        return $this;
    }

    public function getFkTarif() 
    {
        return $this->fkTarif;
    }

    public function setFkTarif(?Tarif $fkTarif): self
    {
        $this->fkTarif = $fkTarif;

        return $this;
    }

    public function getFkClient(): ?Clients
    {
        return $this->fkClient;
    }

    public function setFkClient(?Clients $fkClient): self
    {
        $this->fkClient = $fkClient;

        return $this;
    }

    public function getFkEntreprise(): ?Entreprise
    {
        return $this->fkEntreprise;
    }

    public function setFkEntreprise(?Entreprise $fkEntreprise): self
    {
        $this->fkEntreprise = $fkEntreprise;

        return $this;
    }
}

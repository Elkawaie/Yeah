<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $designation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tarifHoraire;

    /**
     * @ORM\Column(type="bigint")
     */
    private $valeur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenements", mappedBy="fkTarif", cascade={"remove"})
     */
    private $fkEvenementTarif;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Entreprise", inversedBy="fkTarifEntreprise", cascade={"remove"})
     */
    private $fkEntrepriseTarif;


  

    public function __construct()
    {
        $this->fkEvenementTarif = new ArrayCollection();
        $this->fkEntrepriseTarif = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getTarifHoraire(): ?bool
    {
        return $this->tarifHoraire;
    }

    public function setTarifHoraire(bool $tarifHoraire): self
    {
        $this->tarifHoraire = $tarifHoraire;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * @return Collection|Evenements[]
     */
    public function getFkEvenementTarif(): Collection
    {
        return $this->fkEvenementTarif;
    }

    public function addFkEvenementTarif(Evenements $fkEvenementTarif): self
    {
        if (!$this->fkEvenementTarif->contains($fkEvenementTarif)) {
            $this->fkEvenementTarif[] = $fkEvenementTarif;
            $fkEvenementTarif->setFkTarif($this);
        }

        return $this;
    }

    public function removeFkEvenementTarif(Evenements $fkEvenementTarif): self
    {
        if ($this->fkEvenementTarif->contains($fkEvenementTarif)) {
            $this->fkEvenementTarif->removeElement($fkEvenementTarif);
            // set the owning side to null (unless already changed)
            if ($fkEvenementTarif->getFkTarif() === $this) {
                $fkEvenementTarif->setFkTarif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Entreprise[]
     */
    public function getFkEntrepriseTarif(): Collection
    {
        return $this->fkEntrepriseTarif;
    }

    public function addFkEntrepriseTarif(Entreprise $fkEntrepriseTarif): self
    {
        if (!$this->fkEntrepriseTarif->contains($fkEntrepriseTarif)) {
            $this->fkEntrepriseTarif[] = $fkEntrepriseTarif;
        }

        return $this;
    }

    public function removeFkEntrepriseTarif(Entreprise $fkEntrepriseTarif): self
    {
        if ($this->fkEntrepriseTarif->contains($fkEntrepriseTarif)) {
            $this->fkEntrepriseTarif->removeElement($fkEntrepriseTarif);
        }

        return $this;
    }



}

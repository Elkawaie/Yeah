<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     */
    private $SiretSiren;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenements", mappedBy="fkEntreprise", cascade={"remove"})
     */
    private $fkEvenement;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="fkEntreprise", cascade={"remove"})
     */
    private $fkUser;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tarif", mappedBy="fkEntrepriseTarif", cascade={"remove"})
     */
    private $fkTarifEntreprise;


    public function __construct()
    {
        $this->fkEvenement = new ArrayCollection();
        $this->fkUser = new ArrayCollection();
        $this->fkTarifEntreprise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiretSiren(): ?int
    {
        return $this->SiretSiren;
    }

    public function setSiretSiren(int $SiretSiren): self
    {
        $this->SiretSiren = $SiretSiren;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->CodePostal;
    }

    public function setCodePostal(int $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    /**
     * @return Collection|Evenements[]
     */
    public function getFkEvenement(): Collection
    {
        return $this->fkEvenement;
    }

    public function addFkEvenement(Evenements $fkEvenement): self
    {
        if (!$this->fkEvenement->contains($fkEvenement)) {
            $this->fkEvenement[] = $fkEvenement;
            $fkEvenement->setFkEntreprise($this);
        }

        return $this;
    }

    public function removeFkEvenement(Evenements $fkEvenement): self
    {
        if ($this->fkEvenement->contains($fkEvenement)) {
            $this->fkEvenement->removeElement($fkEvenement);
            // set the owning side to null (unless already changed)
            if ($fkEvenement->getFkEntreprise() === $this) {
                $fkEvenement->setFkEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFkUser(): Collection
    {
        return $this->fkUser;
    }

    public function addFkUser(User $fkUser): self
    {
        if (!$this->fkUser->contains($fkUser)) {
            $this->fkUser[] = $fkUser;
            $fkUser->addFkEntreprise($this);
        }

        return $this;
    }

    public function removeFkUser(User $fkUser): self
    {
        if ($this->fkUser->contains($fkUser)) {
            $this->fkUser->removeElement($fkUser);
            $fkUser->removeFkEntreprise($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tarif[]
     */
    public function getFkTarifEntreprise(): Collection
    {
        return $this->fkTarifEntreprise;
    }

    public function addFkTarifEntreprise(Tarif $fkTarifEntreprise): self
    {
        if (!$this->fkTarifEntreprise->contains($fkTarifEntreprise)) {
            $this->fkTarifEntreprise[] = $fkTarifEntreprise;
            $fkTarifEntreprise->addFkEntrepriseTarif($this);
        }

        return $this;
    }

    public function removeFkTarifEntreprise(Tarif $fkTarifEntreprise): self
    {
        if ($this->fkTarifEntreprise->contains($fkTarifEntreprise)) {
            $this->fkTarifEntreprise->removeElement($fkTarifEntreprise);
            $fkTarifEntreprise->removeFkEntrepriseTarif($this);
        }

        return $this;
    }


}

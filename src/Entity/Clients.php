<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientsRepository")
 */
class Clients
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="date")
     */
    private $DateNaissance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenements", mappedBy="fkClient", cascade={"remove"})
     */
    private $fkEvenementClient;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Ville;

    public function __construct()
    {
        $this->fkEvenementClient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    /**
     * @return Collection|Evenements[]
     */
    public function getFkEvenementClient(): Collection
    {
        return $this->fkEvenementClient;
    }

    public function addFkEvenementClient(Evenements $fkEvenementClient): self
    {
        if (!$this->fkEvenementClient->contains($fkEvenementClient)) {
            $this->fkEvenementClient[] = $fkEvenementClient;
            $fkEvenementClient->setFkClient($this);
        }

        return $this;
    }

    public function removeFkEvenementClient(Evenements $fkEvenementClient): self
    {
        if ($this->fkEvenementClient->contains($fkEvenementClient)) {
            $this->fkEvenementClient->removeElement($fkEvenementClient);
            // set the owning side to null (unless already changed)
            if ($fkEvenementClient->getFkClient() === $this) {
                $fkEvenementClient->setFkClient(null);
            }
        }

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
}

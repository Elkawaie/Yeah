<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TvaRepository")
 */
class Tva
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
     * @ORM\Column(type="float")
     */
    private $taux;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenements", mappedBy="fkTva", cascade={"remove"})
     */
    private $fkEvenementTva;

    public function __construct()
    {
        $this->fkEvenementTva = new ArrayCollection();
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

    public function getTaux(): ?int
    {
        return $this->taux;
    }

    public function setTaux(int $taux): self
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * @return Collection|Evenements[]
     */
    public function getFkEvenementTva(): Collection
    {
        return $this->fkEvenementTva;
    }

    public function addFkEvenementTva(Evenements $fkEvenementTva): self
    {
        if (!$this->fkEvenementTva->contains($fkEvenementTva)) {
            $this->fkEvenementTva[] = $fkEvenementTva;
            $fkEvenementTva->setFkTva($this);
        }

        return $this;
    }

    public function removeFkEvenementTva(Evenements $fkEvenementTva): self
    {
        if ($this->fkEvenementTva->contains($fkEvenementTva)) {
            $this->fkEvenementTva->removeElement($fkEvenementTva);
            // set the owning side to null (unless already changed)
            if ($fkEvenementTva->getFkTva() === $this) {
                $fkEvenementTva->setFkTva(null);
            }
        }

        return $this;
    }
}

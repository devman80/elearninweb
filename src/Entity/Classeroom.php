<?php

namespace App\Entity;

use App\Repository\ClasseroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseroomRepository::class)]
class Classeroom extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'classeroom', targetEntity: Inscrire::class)]
    private Collection $inscrires;

    #[ORM\OneToMany(mappedBy: 'classeroom', targetEntity: Dispenser::class)]
    private Collection $dispensers;

    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
        $this->dispensers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    public function addInscrire(Inscrire $inscrire): self
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setClasseroom($this);
        }

        return $this;
    }

    public function removeInscrire(Inscrire $inscrire): self
    {
        if ($this->inscrires->removeElement($inscrire)) {
            // set the owning side to null (unless already changed)
            if ($inscrire->getClasseroom() === $this) {
                $inscrire->setClasseroom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dispenser>
     */
    public function getDispensers(): Collection
    {
        return $this->dispensers;
    }

    public function addDispenser(Dispenser $dispenser): self
    {
        if (!$this->dispensers->contains($dispenser)) {
            $this->dispensers->add($dispenser);
            $dispenser->setClasseroom($this);
        }

        return $this;
    }

    public function removeDispenser(Dispenser $dispenser): self
    {
        if ($this->dispensers->removeElement($dispenser)) {
            // set the owning side to null (unless already changed)
            if ($dispenser->getClasseroom() === $this) {
                $dispenser->setClasseroom(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $volumeheure = null;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    private ?Matiere $matiere = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Dispenser::class)]
    private Collection $dispensers;

    public function __construct()
    {
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

    public function getVolumeheure(): ?string
    {
        return $this->volumeheure;
    }

    public function setVolumeheure(?string $volumeheure): self
    {
        $this->volumeheure = $volumeheure;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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
            $dispenser->setModule($this);
        }

        return $this;
    }

    public function removeDispenser(Dispenser $dispenser): self
    {
        if ($this->dispensers->removeElement($dispenser)) {
            // set the owning side to null (unless already changed)
            if ($dispenser->getModule() === $this) {
                $dispenser->setModule(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Inscription::class)]
    private Collection $inscriptions;

   

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Dispenser::class)]
    private Collection $dispensers;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Matiere::class)]
    private Collection $matieres;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->dispensers = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setSection($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSection() === $this) {
                $inscription->setSection(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->libelle;
    }


    /**
     * @return Collection<int, Dispenser>
     */
    public function getDispensers(): Collection
    {
        return $this->dispensers;
    }

    public function addDispenser(Dispenser $dispenser): static
    {
        if (!$this->dispensers->contains($dispenser)) {
            $this->dispensers->add($dispenser);
            $dispenser->setSection($this);
        }

        return $this;
    }

    public function removeDispenser(Dispenser $dispenser): static
    {
        if ($this->dispensers->removeElement($dispenser)) {
            // set the owning side to null (unless already changed)
            if ($dispenser->getSection() === $this) {
                $dispenser->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->setSection($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getSection() === $this) {
                $matiere->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setSection($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSection() === $this) {
                $user->setSection(null);
            }
        }

        return $this;
    }
}

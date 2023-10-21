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


    #[ORM\OneToMany(mappedBy: 'section', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(nullable: true)]
    private ?int $scolarite = null;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Composition::class)]
    private Collection $compositions;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Note::class)]
    private Collection $notes;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->dispensers = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->compositions = new ArrayCollection();
        $this->notes = new ArrayCollection();
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
        return $this->libelle .' Montant '. $this->scolarite ;
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

    public function getScolarite(): ?int
    {
        return $this->scolarite;
    }

    public function setScolarite(?int $scolarite): static
    {
        $this->scolarite = $scolarite;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setSection($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getSection() === $this) {
                $paiement->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Composition>
     */
    public function getCompositions(): Collection
    {
        return $this->compositions;
    }

    public function addComposition(Composition $composition): static
    {
        if (!$this->compositions->contains($composition)) {
            $this->compositions->add($composition);
            $composition->setSection($this);
        }

        return $this;
    }

    public function removeComposition(Composition $composition): static
    {
        if ($this->compositions->removeElement($composition)) {
            // set the owning side to null (unless already changed)
            if ($composition->getSection() === $this) {
                $composition->setSection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setSection($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getSection() === $this) {
                $note->setSection(null);
            }
        }

        return $this;
    }
}

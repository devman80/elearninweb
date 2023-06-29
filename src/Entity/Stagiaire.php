<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
      #[Assert\Regex(
        pattern: '/^[0-9a-zA-Z-\s\'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/',
        htmlPattern: '^[a-zA-Z]+$',
        message: 'Your name cannot contain a number',
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez saisir le prénom SVP?')]
    private ?string $prenom = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez saisir le sexe SVP?')]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateinscrit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brochureFilename = null;

 

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: Evaluation::class)]
    private Collection $evaluations;

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: Inscrire::class)]
    private Collection $inscrires;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
        $this->inscrires = new ArrayCollection();
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

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateinscrit(): ?\DateTimeInterface
    {
        return $this->dateinscrit;
    }

    public function setDateinscrit(?\DateTimeInterface $dateinscrit): self
    {
        $this->dateinscrit = $dateinscrit;

        return $this;
    }

    public function getBrochureFilename(): ?string
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename(?string $brochureFilename): self
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }

  

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setStagiaire($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getStagiaire() === $this) {
                $evaluation->setStagiaire(null);
            }
        }

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
            $inscrire->setStagiaire($this);
        }

        return $this;
    }

    public function removeInscrire(Inscrire $inscrire): self
    {
        if ($this->inscrires->removeElement($inscrire)) {
            // set the owning side to null (unless already changed)
            if ($inscrire->getStagiaire() === $this) {
                $inscrire->setStagiaire(null);
            }
        }

        return $this;
    }
}

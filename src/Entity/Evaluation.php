<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateevaluation = null;

    #[ORM\Column(nullable: true)]
    private ?int $coefficiant = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalcoef = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    private ?Stagiaire $stagiaire = null;

    #[ORM\ManyToOne(inversedBy: 'evaluations')]
    private ?Enseignant $enseignant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDateevaluation(): ?\DateTimeInterface
    {
        return $this->dateevaluation;
    }

    public function setDateevaluation(?\DateTimeInterface $dateevaluation): self
    {
        $this->dateevaluation = $dateevaluation;

        return $this;
    }

    public function getCoefficiant(): ?int
    {
        return $this->coefficiant;
    }

    public function setCoefficiant(?int $coefficiant): self
    {
        $this->coefficiant = $coefficiant;

        return $this;
    }

    public function getTotalcoef(): ?int
    {
        return $this->totalcoef;
    }

    public function setTotalcoef(?int $totalcoef): self
    {
        $this->totalcoef = $totalcoef;

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

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): self
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }
}

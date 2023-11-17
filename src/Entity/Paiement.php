<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modepaiement = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantpaiement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datepaiement = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Inscription $inscription = null;

    #[ORM\Column(nullable: true)]
    private ?int $restepaie = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Section $section = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModepaiement(): ?string
    {
        return $this->modepaiement;
    }

    public function setModepaiement(?string $modepaiement): self
    {
        $this->modepaiement = $modepaiement;

        return $this;
    }

    public function getMontantpaiement(): ?int
    {
        return $this->montantpaiement;
    }

    public function setMontantpaiement(?int $montantpaiement): self
    {
        $this->montantpaiement = $montantpaiement;

        return $this;
    }

    public function getDatepaiement(): ?\DateTimeInterface
    {
        return $this->datepaiement;
    }

    public function setDatepaiement(?\DateTimeInterface $datepaiement): self
    {
        $this->datepaiement = $datepaiement;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getRestepaie(): ?int
    {
        return $this->restepaie;
    }

    public function setRestepaie(?int $restepaie): static
    {
        $this->restepaie = $restepaie;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): static
    {
        $this->section = $section;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

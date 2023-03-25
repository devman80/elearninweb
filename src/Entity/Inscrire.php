<?php

namespace App\Entity;

use App\Repository\InscrireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscrireRepository::class)]
class Inscrire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateinscrire = null;

    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    private ?Classeroom $classeroom = null;

    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    private ?Stagiaire $stagiaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateinscrire(): ?\DateTimeInterface
    {
        return $this->dateinscrire;
    }

    public function setDateinscrire(?\DateTimeInterface $dateinscrire): self
    {
        $this->dateinscrire = $dateinscrire;

        return $this;
    }

    public function getClasseroom(): ?Classeroom
    {
        return $this->classeroom;
    }

    public function setClasseroom(?Classeroom $classeroom): self
    {
        $this->classeroom = $classeroom;

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
}

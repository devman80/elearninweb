<?php

namespace App\Entity;

use App\Repository\VersementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersementRepository::class)]
class Versement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantversement = null;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateversement = null;

    #[ORM\ManyToOne(inversedBy: 'versements')]
    private ?Section $section = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantversement(): ?int
    {
        return $this->montantversement;
    }

    public function setMontantversement(int $montantversement): static
    {
        $this->montantversement = $montantversement;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDateversement(): ?\DateTimeInterface
    {
        return $this->dateversement;
    }

    public function setDateversement(\DateTimeInterface $dateversement): static
    {
        $this->dateversement = $dateversement;

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
}

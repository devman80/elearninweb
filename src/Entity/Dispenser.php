<?php

namespace App\Entity;

use App\Repository\DispenserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispenserRepository::class)]
class Dispenser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datedispenser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brochureFilename = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $audio = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $video = null;

    #[ORM\ManyToOne(inversedBy: 'dispensers')]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'dispensers')]
    private ?Classeroom $classeroom = null;

    #[ORM\ManyToOne(inversedBy: 'dispensers')]
    private ?Module $module = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedispenser(): ?\DateTimeInterface
    {
        return $this->datedispenser;
    }

    public function setDatedispenser(?\DateTimeInterface $datedispenser): self
    {
        $this->datedispenser = $datedispenser;

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

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

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

    public function getClasseroom(): ?Classeroom
    {
        return $this->classeroom;
    }

    public function setClasseroom(?Classeroom $classeroom): self
    {
        $this->classeroom = $classeroom;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[UniqueEntity(fields: ['$cmu'], message: 'Numéro CMU déjà utilisé')]
#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

     #[Assert\Regex(
        pattern: '/^[0-9a-zA-Z-\s\'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]+$/',
       // htmlPattern: '^[a-zA-Z]+$',
        message: 'Your name cannot contain a number',
    )]
    #[ORM\Column(length: 255)]
    #[ORM\Groups("public")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups("public")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $brochureFilename = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $sexe = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $contact = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $statutmatri = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[ORM\Groups("public")]
    private ?\DateTimeInterface $datenaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $lieuresidence = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $paysnaiss = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $paysvit = null;

       #[ORM\ManyToOne(inversedBy: 'Stagiaires')]
    private ?Section $section = null;
    
    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $typepiece = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    #[ORM\Groups("public")]
    private ?string $numpiece = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $handicap = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $typehandicap = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $telephone = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $cmu = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $extraitFilename = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $diplomeFilename = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $cniFilename = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Groups("public")]
    private ?string $cniFilenamerecto = null;

    /**
     * @return string|null
     */
    public function getCniFilenamerecto(): ?string
    {
        return $this->cniFilenamerecto;
    }

    /**
     * @param string|null $cniFilenamerecto
     */
    public function setCniFilenamerecto(?string $cniFilenamerecto): void
    {
        $this->cniFilenamerecto = $cniFilenamerecto;
    }
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    #[ORM\Groups("public")]
    private ?int $montantInscription = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Commune $commune = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Paiement::class)]
    private Collection $paiements;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $certificatFileName = null;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
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

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getStatutmatri(): ?string
    {
        return $this->statutmatri;
    }

    public function setStatutmatri(?string $statutmatri): self
    {
        $this->statutmatri = $statutmatri;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getLieuresidence(): ?string
    {
        return $this->lieuresidence;
    }

    public function setLieuresidence(?string $lieuresidence): self
    {
        $this->lieuresidence = $lieuresidence;

        return $this;
    }

    public function getPaysnaiss(): ?string
    {
        return $this->paysnaiss;
    }

    public function setPaysnaiss(?string $paysnaiss): self
    {
        $this->paysnaiss = $paysnaiss;

        return $this;
    }

    public function getPaysvit(): ?string
    {
        return $this->paysvit;
    }

    public function setPaysvit(?string $paysvit): self
    {
        $this->paysvit = $paysvit;

        return $this;
    }

    public function getTypepiece(): ?string
    {
        return $this->typepiece;
    }

    public function setTypepiece(?string $typepiece): self
    {
        $this->typepiece = $typepiece;

        return $this;
    }

    public function getNumpiece(): ?string
    {
        return $this->numpiece;
    }

    public function setNumpiece(?string $numpiece): self
    {
        $this->numpiece = $numpiece;

        return $this;
    }

    public function getHandicap(): ?string
    {
        return $this->handicap;
    }

    public function setHandicap(?string $handicap): self
    {
        $this->handicap = $handicap;

        return $this;
    }

    public function getTypehandicap(): ?string
    {
        return $this->typehandicap;
    }

    public function setTypehandicap(?string $typehandicap): self
    {
        $this->typehandicap = $typehandicap;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCmu(): ?string
    {
        return $this->cmu;
    }

    public function setCmu(?string $cmu): self
    {
        $this->cmu = $cmu;

        return $this;
    }

    

    public function getExtraitFilename(): ?string
    {
        return $this->extraitFilename;
    }

    public function setExtraitFilename(?string $extraitFilename): self
    {
        $this->extraitFilename = $extraitFilename;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDiplomeFilename(): ?string
    {
        return $this->diplomeFilename;
    }

    public function setDiplomeFilename(?string $diplomeFilename): self
    {
        $this->diplomeFilename = $diplomeFilename;

        return $this;
    }

    public function getCniFilename(): ?string
    {
        return $this->cniFilename;
    }

    public function setCniFilename(?string $cniFilename): self
    {
        $this->cniFilename = $cniFilename;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMontantInscription(): ?int
    {
        return $this->montantInscription;
    }

    public function setMontantInscription(?int $montantInscription): self
    {
        $this->montantInscription = $montantInscription;

        return $this;
    }

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setInscription($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getInscription() === $this) {
                $paiement->setInscription(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
    
      public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getCertificatFileName(): ?string
    {
        return $this->certificatFileName;
    }

    public function setCertificatFileName(?string $certificatFileName): self
    {
        $this->certificatFileName = $certificatFileName;

        return $this;
    }
}

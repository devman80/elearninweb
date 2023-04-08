<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\MappedSuperclass]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware:false)]

class AbstractEntity {


      #[Gedmo\Timestampable(on: 'create')]
      #[ORM\Column(type:'datetime', nullable:true)]

    public $createdAt;


      #[ORM\ManyToOne(targetEntity:'App\Entity\User')]
      #[ORM\JoinColumn(nullable:true, referencedColumnName:'id')]

    protected $createdBy;
    

     #[Gedmo\IpTraceable(on:'create')]
     #[ORM\Column(length:45, nullable:true)]

    protected $createdFromIp;


      #[Gedmo\Timestampable(on:'update')]
      #[ORM\Column(type:'datetime',nullable:true)]

    protected $updatedAt;

     #[ORM\ManyToOne(targetEntity:'App\Entity\User')]
     #[ORM\JoinColumn(nullable:true, referencedColumnName:'id')]

    protected $updatedBy;

     #[Gedmo\IpTraceable(on:'update')]
     #[ORM\Column(length:45, nullable:true)]

    protected $updatedFromIp;
    
    #[ORM\Column(name:'deletedAt', type:'datetime', nullable:true)]
    protected $deletedAt;

    #[ORM\ManyToOne(targetEntity:'App\Entity\User')]
    #[ORM\JoinColumn(nullable:true, referencedColumnName:'id')]

    protected $deletedBy;


     #[ORM\Column(length:45, nullable:true)]
    protected $deletedFromIp;

    #[ORM\Column(type:'boolean') ]
    protected $editable = true;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedFromIp()
    {
        return $this->createdFromIp;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedFromIp()
    {
        return $this->updatedFromIp;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @return mixed
     */
    public function getDeletedFromIp()
    {
        return $this->deletedFromIp;
    }

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param mixed $createdFromIp
     */
    public function setCreatedFromIp($createdFromIp): void
    {
        $this->createdFromIp = $createdFromIp;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @param mixed $updatedFromIp
     */
    public function setUpdatedFromIp($updatedFromIp): void
    {
        $this->updatedFromIp = $updatedFromIp;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @param mixed $deletedBy
     */
    public function setDeletedBy($deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }

    /**
     * @param mixed $deletedFromIp
     */
    public function setDeletedFromIp($deletedFromIp): void
    {
        $this->deletedFromIp = $deletedFromIp;
    }

    /**
     * @param bool $editable
     */
    public function setEditable(bool $editable): void
    {
        $this->editable = $editable;
    }


}

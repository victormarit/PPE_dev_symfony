<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $socialSecurityNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bloodType;

    /**
     * @ORM\OneToMany(targetEntity=Stay::class, mappedBy="idPatient")
     */
    private $stays;

    /**
     * @ORM\OneToMany(targetEntity=Manage::class, mappedBy="idPatient", orphanRemoval=true)
     */
    private $manages;

    /**
     * @ORM\Column(type="boolean", options={"default": 1})
     */
    private $activate = 1;

    public function __construct()
    {
        $this->stays = new ArrayCollection();
        $this->manages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSocialSecurityNumber(): ?string
    {
        return $this->socialSecurityNumber;
    }

    public function setSocialSecurityNumber(string $socialSecurityNumber): self
    {
        $this->socialSecurityNumber = $socialSecurityNumber;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBloodType(): ?string
    {
        return $this->bloodType;
    }

    public function setBloodType(?string $bloodType): self
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    /**
     * @return Collection|Stay[]
     */
    public function getStays(): Collection
    {
        return $this->stays;
    }

    public function addStay(Stay $stay): self
    {
        if (!$this->stays->contains($stay)) {
            $this->stays[] = $stay;
            $stay->setIdPatient($this);
        }

        return $this;
    }

    public function removeStay(Stay $stay): self
    {
        if ($this->stays->removeElement($stay)) {
            // set the owning side to null (unless already changed)
            if ($stay->getIdPatient() === $this) {
                $stay->setIdPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Manage[]
     */
    public function getManages(): Collection
    {
        return $this->manages;
    }

    public function addManage(Manage $manage): self
    {
        if (!$this->manages->contains($manage)) {
            $this->manages[] = $manage;
            $manage->setIdPatient($this);
        }

        return $this;
    }

    public function removeManage(Manage $manage): self
    {
        if ($this->manages->removeElement($manage)) {
            // set the owning side to null (unless already changed)
            if ($manage->getIdPatient() === $this) {
                $manage->setIdPatient(null);
            }
        }

        return $this;
    }

    public function getActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }
}

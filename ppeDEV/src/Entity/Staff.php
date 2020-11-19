<?php

namespace App\Entity;

use App\Repository\StaffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StaffRepository::class)
 */
class Staff
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
    private $login;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="staff")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idService;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="staff")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idRole;

    /**
     * @ORM\OneToMany(targetEntity=Manage::class, mappedBy="idStaff", orphanRemoval=true)
     */
    private $manages;

    /**
     * @ORM\OneToMany(targetEntity=AddStay::class, mappedBy="idStaff", orphanRemoval=true)
     */
    private $addStays;

    public function __construct()
    {
        $this->manages = new ArrayCollection();
        $this->addStays = new ArrayCollection();
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIdService(): ?Service
    {
        return $this->idService;
    }

    public function setIdService(?Service $idService): self
    {
        $this->idService = $idService;

        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->idRole;
    }

    public function setIdRole(?Role $idRole): self
    {
        $this->idRole = $idRole;

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
            $manage->setIdStaff($this);
        }

        return $this;
    }

    public function removeManage(Manage $manage): self
    {
        if ($this->manages->removeElement($manage)) {
            // set the owning side to null (unless already changed)
            if ($manage->getIdStaff() === $this) {
                $manage->setIdStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AddStay[]
     */
    public function getAddStays(): Collection
    {
        return $this->addStays;
    }

    public function addAddStay(AddStay $addStay): self
    {
        if (!$this->addStays->contains($addStay)) {
            $this->addStays[] = $addStay;
            $addStay->setIdStaff($this);
        }

        return $this;
    }

    public function removeAddStay(AddStay $addStay): self
    {
        if ($this->addStays->removeElement($addStay)) {
            // set the owning side to null (unless already changed)
            if ($addStay->getIdStaff() === $this) {
                $addStay->setIdStaff(null);
            }
        }

        return $this;
    }
}

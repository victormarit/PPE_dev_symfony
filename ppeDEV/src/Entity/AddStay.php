<?php

namespace App\Entity;

use App\Repository\AddStayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddStayRepository::class)
 */
class AddStay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Stay::class, inversedBy="addStays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStay;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="addStays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStaff;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStay(): ?Stay
    {
        return $this->idStay;
    }

    public function setIdStay(?Stay $idStay): self
    {
        $this->idStay = $idStay;

        return $this;
    }

    public function getIdStaff(): ?Staff
    {
        return $this->idStaff;
    }

    public function setIdStaff(?Staff $idStaff): self
    {
        $this->idStaff = $idStaff;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }
}

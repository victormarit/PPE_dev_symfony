<?php

namespace App\Entity;

use App\Repository\ManageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManageRepository::class)
 */
class Manage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modification;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="manages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPatient;

    /**
     * @ORM\ManyToOne(targetEntity=Staff::class, inversedBy="manages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStaff;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdPatient(): ?Patient
    {
        return $this->idPatient;
    }

    public function setIdPatient(?Patient $idPatient): self
    {
        $this->idPatient = $idPatient;

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
}

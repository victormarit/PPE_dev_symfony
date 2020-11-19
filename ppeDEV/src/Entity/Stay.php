<?php

namespace App\Entity;

use App\Repository\StayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StayRepository::class)
 */
class Stay
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
    private $entryDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $leaveDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Bed::class, inversedBy="stays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idBed;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="stays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPatient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getLeaveDate(): ?\DateTimeInterface
    {
        return $this->leaveDate;
    }

    public function setLeaveDate(\DateTimeInterface $leaveDate): self
    {
        $this->leaveDate = $leaveDate;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIdBed(): ?Bed
    {
        return $this->idBed;
    }

    public function setIdBed(?Bed $idBed): self
    {
        $this->idBed = $idBed;

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
}

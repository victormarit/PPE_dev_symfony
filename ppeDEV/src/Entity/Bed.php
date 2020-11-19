<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BedRepository::class)
 */
class Bed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=HospitalRoom::class, inversedBy="beds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idHospitalRoom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getIdHospitalRoom(): ?HospitalRoom
    {
        return $this->idHospitalRoom;
    }

    public function setIdHospitalRoom(?HospitalRoom $idHospitalRoom): self
    {
        $this->idHospitalRoom = $idHospitalRoom;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=HospitalRoom::class, mappedBy="idService")
     */
    private $hospitalRooms;

    public function __construct()
    {
        $this->hospitalRooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|HospitalRoom[]
     */
    public function getHospitalRooms(): Collection
    {
        return $this->hospitalRooms;
    }

    public function addHospitalRoom(HospitalRoom $hospitalRoom): self
    {
        if (!$this->hospitalRooms->contains($hospitalRoom)) {
            $this->hospitalRooms[] = $hospitalRoom;
            $hospitalRoom->setIdService($this);
        }

        return $this;
    }

    public function removeHospitalRoom(HospitalRoom $hospitalRoom): self
    {
        if ($this->hospitalRooms->removeElement($hospitalRoom)) {
            // set the owning side to null (unless already changed)
            if ($hospitalRoom->getIdService() === $this) {
                $hospitalRoom->setIdService(null);
            }
        }

        return $this;
    }
}

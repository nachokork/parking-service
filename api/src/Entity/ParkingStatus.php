<?php

namespace App\Entity;

use App\Repository\ParkingStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkingStatusRepository::class)]
class ParkingStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isOccupied = null;

    #[ORM\Column]
    private ?\DateTime $timeStamp = null;

    #[ORM\ManyToOne(inversedBy: 'statusHistory')]
    private ?ParkingSpace $parkingSpace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isOccupied(): ?bool
    {
        return $this->isOccupied;
    }

    public function setIsOccupied(bool $isOccupied): static
    {
        $this->isOccupied = $isOccupied;

        return $this;
    }

    public function getTimeStamp(): ?\DateTime
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(\DateTime $timeStamp): static
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    public function getParkingSpace(): ?ParkingSpace
    {
        return $this->parkingSpace;
    }

    public function setParkingSpace(?ParkingSpace $parkingSpace): static
    {
        $this->parkingSpace = $parkingSpace;

        return $this;
    }
}

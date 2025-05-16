<?php

namespace App\Entity;

use App\Repository\ParkingSpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkingSpaceRepository::class)]
class ParkingSpace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    #[ORM\Column]
    private ?bool $isOccupied = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $lastStatusChange = null;

    #[ORM\ManyToOne(inversedBy: 'spaces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ParkingZone $parkingZone = null;

    /**
     * @var Collection<int, ParkingStatus>
     */
    #[ORM\OneToMany(targetEntity: ParkingStatus::class, mappedBy: 'parkingSpace')]
    private Collection $statusHistory;

    public function __construct()
    {
        $this->statusHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
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

    public function getLastStatusChange(): ?string
    {
        return $this->lastStatusChange;
    }

    public function setLastStatusChange(?string $lastStatusChange): static
    {
        $this->lastStatusChange = $lastStatusChange;

        return $this;
    }

    public function getParkingZone(): ?ParkingZone
    {
        return $this->parkingZone;
    }

    public function setParkingZone(?ParkingZone $parkingZone): static
    {
        $this->parkingZone = $parkingZone;

        return $this;
    }

    /**
     * @return Collection<int, ParkingStatus>
     */
    public function getStatusHistory(): Collection
    {
        return $this->statusHistory;
    }

    public function addStatusHistory(ParkingStatus $statusHistory): static
    {
        if (!$this->statusHistory->contains($statusHistory)) {
            $this->statusHistory->add($statusHistory);
            $statusHistory->setParkingSpace($this);
        }

        return $this;
    }

    public function removeStatusHistory(ParkingStatus $statusHistory): static
    {
        if ($this->statusHistory->removeElement($statusHistory)) {
            // set the owning side to null (unless already changed)
            if ($statusHistory->getParkingSpace() === $this) {
                $statusHistory->setParkingSpace(null);
            }
        }

        return $this;
    }
}

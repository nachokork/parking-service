<?php

namespace App\Entity;

use App\Repository\ParkingZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkingZoneRepository::class)]
class ParkingZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ParkingSpace>
     */
    #[ORM\OneToMany(targetEntity: ParkingSpace::class, mappedBy: 'parkingZone', orphanRemoval: true)]
    private Collection $spaces;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ParkingSpace>
     */
    public function getSpaces(): Collection
    {
        return $this->spaces;
    }

    public function addSpace(ParkingSpace $space): static
    {
        if (!$this->spaces->contains($space)) {
            $this->spaces->add($space);
            $space->setParkingZone($this);
        }

        return $this;
    }

    public function removeSpace(ParkingSpace $space): static
    {
        if ($this->spaces->removeElement($space)) {
            // set the owning side to null (unless already changed)
            if ($space->getParkingZone() === $this) {
                $space->setParkingZone(null);
            }
        }

        return $this;
    }
}

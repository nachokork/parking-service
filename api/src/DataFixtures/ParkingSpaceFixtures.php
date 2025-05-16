<?php

namespace App\DataFixtures;

use App\Entity\ParkingSpace;
use App\Entity\ParkingZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParkingSpaceFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($z = 1; $z <= 5; $z++) {
            $zone = $this->getReference("zone_$z", ParkingZone::class);
            for ($i = 1; $i <= 5; $i++) {
                $space = new ParkingSpace();
                $space->setIdentifier("Z{$z}S{$i}");
                $space->setParkingZone($zone);
                $space->setIsOccupied(false);
                $space->setLastStatusChange((new \DateTime('-1 day'))->format('Y-m-d H:i:s'));

                $manager->persist($space);

                $this->addReference("space_z{$z}_{$i}", $space);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2; // El número 2 asegura que este fixture se cargue después de ParkingZoneFixtures.
    }
}

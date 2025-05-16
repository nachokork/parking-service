<?php

namespace App\DataFixtures;

namespace App\DataFixtures;

use App\Entity\ParkingZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ParkingZoneFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $zone = new ParkingZone();
            $zone->setName("Zona $i");
            $manager->persist($zone);

            // Guardamos la referencia de cada zona
            $this->addReference("zone_$i", $zone);
        }

        $manager->flush();
    }

    // Se carga primero porque tiene el orden 1
    public function getOrder(): int
    {
        return 1;
    }
}

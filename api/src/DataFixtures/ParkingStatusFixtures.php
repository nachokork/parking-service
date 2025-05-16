<?php

namespace App\DataFixtures;

namespace App\DataFixtures;

use App\Entity\ParkingStatus;
use App\Entity\ParkingSpace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParkingStatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($z = 1; $z <= 5; $z++) {
            for ($i = 1; $i <= 5; $i++) {
                $space = $this->getReference("space_z{$z}_{$i}", ParkingSpace::class);
                for ($j = 0; $j < 3; $j++) {
                    $status = new ParkingStatus();
                    $status->setParkingSpace($space);
                    $status->setIsOccupied((bool) random_int(0, 1));
                    $status->setTimestamp(new \DateTime("-" . ($j + 1) . " hours"));

                    $manager->persist($status);
                }
            }
        }

        $manager->flush();
    }

    // Definir la dependencia con ParkingSpaceFixtures
    public function getDependencies(): array
    {
        return [ParkingSpaceFixtures::class];
    }
}
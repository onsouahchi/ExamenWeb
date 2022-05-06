<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Section;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $section = new Section();
            $section->setDesignation('Section '.$i);
            $manager->persist($section);
        }
        $manager->flush();
    }
}

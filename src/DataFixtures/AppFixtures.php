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
    private $repository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->repository = $this->doctrine->getRepository(Section::class);
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 6; $i++) {
            $section = new Section();
            $section->setDesignation('Section '.$i);
            $manager->persist($section);
        }
        $manager->flush();

        $faker = Factory::create('fr');
        for ($i = 0; $i < 15; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->lastName);
            $etudiant->setPrenom($faker->firstName);
            $etudiant->setSection($this->repository->findOneBy(["designation"=> 'Section '.rand(0,5)]));
            $manager->persist($etudiant);
        }

        $manager->flush();
    }
}

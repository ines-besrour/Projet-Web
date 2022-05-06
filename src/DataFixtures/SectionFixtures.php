<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "GL",
            "RT",
            "IIA",
            "IMI"
        ];
        $faker=Factory::create();
        for ($i=0; $i<count($data);$i++){
            $section=new Section();
            $section->setDesignation($data[$i]);
            $manager->persist($section);
        }

        $manager->flush();
    }
}

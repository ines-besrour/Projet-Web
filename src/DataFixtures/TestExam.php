<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestExam extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tab=['test','test','test','test','test','test','test','test','test','test','test','test'];
        foreach ($tab as $element){
            $test= new \App\Entity\TestExam();
            $test->setDesignation($element);
            $manager->persist($test);
        }
        $manager->flush();
    }
}

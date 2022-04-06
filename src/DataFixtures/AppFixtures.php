<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create();
        $json_file = 'people.json';
        json_decode($json_file);

        $student = new Student();
        $pieces = explode(" ", $json_file);
        $student->setName($pieces[0]);
        // $student->setFirstName($pieces[1]);
        $student->setFirstName(($faker->firstName));

        $student->setPassword(rand());
        // $student->setFirstName($pieces[1]);
        // $student->setFirstName($pieces[1]);


        $manager->persist($student);
        $manager->flush();


        // json_encode()
        // foreach ($variable as $key => $value) {
        //     # code...
        // }
        


    }
}

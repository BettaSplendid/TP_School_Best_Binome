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

        $Json = file_get_contents("src/DataFixtures/people2.json");
        // Converts to an array 
        $myarray = json_decode($Json, true);

        // var_dump($myarray);
        // var_dump($myarray["CP"]);

        
        foreach ($myarray["CP"] as $key => $value) {
            // var_dump("Student: ");
            // var_dump($myarray["CP"][$key0]);
            $pieces = explode(" ", $myarray["CP"][$key]);
            $student = new Student();
            $student->setFirstName($pieces[0]);
            $student->setName($pieces[1]);
            $student->setEmail(($faker->email));
            $student->setUsername($student->getName() . $student->getFirstName() . "du" . rand(0, 100));
            $student->setParentEmail1(($student->getName() . $faker->firstName . "@" . $faker->freeEmailDomain));
            $student->setParentEmail2(($faker->email));
            $student->setGender((bool) mt_rand(0, 1));
            $student->setPassword(rand());

            $manager->persist($student);
            $manager->flush();
        }
    }
}

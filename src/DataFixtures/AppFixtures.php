<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

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

        var_dump("Student: ");
        
        foreach ($myarray["CP"] as $key => $value) {
            // var_dump($myarray["CP"][$key0]);
            $pieces = explode(" ", $myarray["CP"][$key]);
            $student = new Student();
            $student->setFirstName($pieces[0]);
            $student->setName($pieces[1]);
            $student->setUsername($student->getName() . $student->getFirstName() . "du" . rand(0, 100));
            $student->setEmail(($student->getUsername() . rand() . "@" . $faker->freeEmailDomain));
            $student->setParentEmail1(($student->getName() . $faker->firstName . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
            $student->setParentEmail2(($student->getName() . $faker->firstName . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
            $student->setGender((bool) mt_rand(0, 1));
            $student->setPassword(rand());

            $manager->persist($student);
            $manager->flush();
        }

        Var_dump("Professor: ");
        $prof = new Professor();
        $prof->setAge(rand(18, 60));
        $prof->setArrivalDate(new \DateTime());
        $prof->setSalary(rand(1000, 2300));
        $prof->setSection($manager->getRepository(Section::class)->find(1));

    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use stdClass;

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

        //faux etudiant pour connexion 
        $studenta = (new Student())->setFirstName("Amelie")->setName("KLEIN")->setUsername("ak54")->setEmail("ak@gmail.com")->setGender(0)->setPassword("123");
        $studenta->setParentEmail1("22@gmaikl.fr");
        $manager->persist($studenta);

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

        var_dump("Section: ");
        $cp = new Section();
        $cp->setName("CP");
        $manager->persist($cp);

        $ce1 = new Section();
        $ce1->setName("CE1");
        $manager->persist($ce1);


        $ce2 = new Section();
        $ce2->setName("CE2");
        $manager->persist($ce2);


        $cm1 = new Section();
        $cm1->setName("CM1");
        $manager->persist($cm1);


        $cm2 = new Section();
        $cm2->setName("CM2");
        $manager->persist($cm2);
        $manager->flush();

        Var_dump("Professor: ");
        $prof = new Professor();
        $prof->setName("Delenoix");
        $prof->setFirstName("Jean");
        $prof->SetEmail($prof->getName() . $prof->getFirstName() . "@" . $faker->freeEmailDomain);
        $prof->setUsername($prof->getName() . $prof->getFirstName() . "teach");
        $prof->setPassword(rand());

        $prof->setAge(rand(18, 60));
        $prof->setArrivalDate(new \DateTime());
        $prof->setSalary(rand(1000, 2300));
        $prof->setSection($manager->getRepository(Section::class)->findBy(['Name' => 'CP'])[0]);
        $manager->persist($prof);
        $manager->flush();

        // private $email;
        // private $roles = [];
        // private $password;
        // private $Username;
        // private $Name;
        // private $FirstName;

    }
}

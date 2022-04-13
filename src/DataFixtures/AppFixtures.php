<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\Student;
use App\Entity\Director;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        var_dump('Loading data fixtures');
        $faker = Faker\Factory::create();
        $Json = file_get_contents("src/DataFixtures/people2.json");
        $myarray = json_decode($Json, true);
        // var_dump($myarray);
        // var_dump(array_keys($myarray));

        var_dump("Generating Sections: ");
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



        var_dump("Generating Students: ");

        //faux etudiant pour connexion 

        $special_student = new Student();
        $special_student_password = $this->encoder->hashPassword($special_student, "123");
        $special_student->setFirstname("Amelie")->setName("KLEIN")->setUsername("ak54")->setEmail("ak@gmail.com")->setGender(0);
        $special_student->setSection($manager->getRepository(Section::class)->findBy(['name' => 'CP'])[0]);
        $special_student->setParent1("22@gmaikl.fr");
        $special_student->setPassword($special_student_password);

        $manager->persist($special_student);

        $special_student_2 = new Student();
        $special_student_2_password = $this->encoder->hashPassword($special_student_2, "123");
        $special_student_2->setFirstname("Amelie")->setName("KLEIN")->setUsername("ak542")->setEmail("ak2@gmail.com")->setGender(0);
        $special_student_2->setParent1("22@gmaikl.fr");
        $special_student_2->setPassword($special_student_2_password);
        
        $manager->persist($special_student_2);

        $director = new Director();
        $director_password = $this->encoder->hashPassword($director, "director");
        $director->setFirstname("Jean-Jacques")->setName("Goldman")->setUsername("admin")->setEmail("admin@gmail.com")-> setRoles(["ROLE_ADMIN"]);
        $director->setPassword($director_password);
        
        $manager->persist($director);


        $liste_classes = array_keys($myarray);

        foreach ($liste_classes as $key => $value) {
            $current_array = $value;
            foreach ($myarray[$current_array] as $key => $value) {
                // var_dump($myarray["CP"][$key0]);
                $pieces = explode(" ", $myarray[$current_array][$key]);
                $student = new Student();
                $student->setFirstname($pieces[0])-> setRoles(["ROLE_STUDENT"]);
                $student->setName($pieces[1]);
                $student->setUsername($student->getName() . $student->getFirstname() . "du" . rand(0, 100));
                $student->setEmail(($student->getUsername() . rand() . "@" . $faker->freeEmailDomain));
                $student->setParent1(($student->getName() . $faker->firstname . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
                $student->setParent2(($student->getName() . $faker->firstname . $faker->cityPrefix . "@" . $faker->freeEmailDomain));
                $student->setGender((bool) mt_rand(0, 1));
                $student->setPassword(rand());
                $student->setSection($manager->getRepository(Section::class)->findOneBy(['name' => $current_array]));
                $manager->persist($student);
                $manager->flush();
            }
        }

        Var_dump("Generating Professors: ");

        $prof_cp = (object) ['name' => 'Delenoix', 'firstname' => 'Jean', 'section' => 'CP'];
        $prof_ce1 = (object) ['name' => 'Bekritch', 'firstname' => 'Justine', 'section' => 'CE1'];
        $prof_ce2 = (object) ['name' => 'Garbo', 'firstname' => 'Greta', 'section' => 'CE2'];
        $prof_cm1 = (object) ['name' => 'Ghelain', 'firstname' => 'Georges', 'section' => 'CM1'];
        $prof_cm2 = (object) ['name' => 'Charbonnier', 'firstname' => 'Gisèle', 'section' => 'CM2'];

        $all_profs = array($prof_cp, $prof_ce1, $prof_ce2, $prof_cm1, $prof_cm2);
        // var_dump($all_profs);
        foreach ($all_profs as $key => $value) {
            // var_dump($all_profs[$key]);
            $prof = (new Professor())-> setRoles(["ROLE_PROF"]) ;
            $prof->setName($all_profs[$key]->name);
            $prof->setFirstname($all_profs[$key]->firstname);
            $prof->setSection($manager->getRepository(Section::class)->findBy(['name' => $all_profs[$key]->section])[0]);
            $prof->setPassword(rand());

            $prof->SetEmail($prof->getName() . $prof->getFirstname() . "@" . $faker->freeEmailDomain);
            $prof->setUsername($prof->getName() . $prof->getFirstname() . "teach");
            $prof->setAge(rand(18, 60));
            $prof->setArrivaldate(new \DateTime());
            $prof->setSalary(rand(1000, 2300));
            $manager->persist($prof);
        }

        $manager->flush();
        var_dump("Data fixtures loaded, you are clear, champion!");
    }
}

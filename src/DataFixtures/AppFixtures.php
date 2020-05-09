<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        
        
        
        for($i = 0; $i <= 25; $i++) {
            $student = new Student();

            $photo = "https://randomuser.me/api/portraits/lego/" . \random_int(0, 8) . ".jpg";
            
            $student->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setGender('null')
                    ->setAge(\random_int(8, 10))
                    ->setAddress($faker->address())
                    ->setCity($faker->city)
                    ->setPhone($faker->phoneNumber)
                    ->setPhoto($photo);

            $manager->persist($student);
        }

        $manager->flush();
    }
}

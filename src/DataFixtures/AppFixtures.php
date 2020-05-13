<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Student;
use App\Entity\Classroom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        
        $classes = ['CP', 'CE1', 'CE2', 'CM1', 'CM2'];

        for($u = 0; $u < 10; $u++){
            $user = new User;
            $user->setEmail("user$u@gmail.com")
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setNickname($faker->userName)
                ->setRegisteredAt($faker->dateTimeBetween('-1 years'));

            $manager->persist($user);
        }

        for($c = 0; $c < count($classes); $c++){
            $class = new Classroom;
            $class->setTitle($classes[$c]);

            $manager->persist($class);

            for($i = 0; $i < 15; $i++) {
                $student = new Student();
    
                $photo = "https://randomuser.me/api/portraits/lego/" . \random_int(0, 8) . ".jpg";
                
                $student->setFirstName($faker->firstName())
                        ->setLastName($faker->lastName())
                        ->setGender('null')
                        ->setAge(\random_int(8, 10))
                        ->setAddress($faker->address())
                        ->setCity($faker->city)
                        ->setPhone($faker->phoneNumber)
                        ->setPhoto($photo)
                        ->setClassroom($class);
    
                $manager->persist($student);
            }
        }
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        // dummy users
        $users = array(
            ['email' => 'yornletard@gmail.com', 'password' => 'test'],
            ['email' => 'johnhayken@gmail.com', 'password' => 'test'],
            ['email' => 'jackie@gmail.com', 'password' => 'test'],
            ['email' => 'michel@gmail.com', 'password' => 'test'],
        );
        foreach($users as $u){
            $user = new User();
            $user->setEmail($u['email']);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $u['password']
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

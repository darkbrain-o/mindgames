<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encode;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encode = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $password = $this->encode->encodePassword($user, "Gilles-2011");
        $user->setMail('giba1955@orange.fr');
        $user->setRole('ROLE_USER,ROLE_ADMIN');
        $user->setPseudo('gilles');
        // $user->setPassword('Gilles-2011');
        $user->setPassword($password);

        // $user->setPassword($this->encoder->encodePassword($user, 'Gilles-2011'));
        $manager->persist($user);

        $faker = Factory::create('fr_FR');
        // create 20 products! Bam!
        for ($i = 0; $i < 40; $i++) {
            $game = new Game();
            $game->setName('game '.$i);
            $game->setPlatform('ps4 '.$i);
            $game->setPrice(mt_rand(10, 100));
            $game->setStock(mt_rand(10, 100));
            $game->setStatus(mt_rand(1, 3));
            $game->setPegi(mt_rand(1, 3));
            $game->setDescription($faker->text);
            $game->setCreationDate($faker->dateTimeBetween('-2years'));
            $game->setPicture($faker->imageUrl);
            $manager->persist($game);
        }                

        $manager->flush();
    }
//    public function getEncode() {
//        return $this->encode;
//    }
//
//    public function setEncode($encode) {
//        $this->encode = $encode;
//        return $this;
//    }

}

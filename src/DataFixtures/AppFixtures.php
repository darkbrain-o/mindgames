<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        $user = new User();

        $user->setMail('patrick.buffone@gmail.com');
        // $user->setRole('ROLE_USER,ROLE_ADMIN');
        $user->setPseudo('patrick');
        $user->setPassword('patrick');

        // $user->setPassword($this->encoder->encodePassword($user, 'patrick'));
        $manager->persist($user);

        $faker = Factory::create('fr_FR');
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
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
}

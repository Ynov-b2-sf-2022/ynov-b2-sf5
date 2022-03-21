<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $categories = [];
        for ($i = 0; $i < 25; $i++) {
            $category = new Category();
            $category->setName($faker->words(2, true));
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < 200; $i++) {
            $article = new Article();
            $article->setTitle($faker->words($faker->numberBetween(2, 7), true))
                ->setDate($faker->dateTimeBetween('-2 years'))
                ->setVisible($faker->boolean(80))
                ->setContent($faker->realTextBetween(150, 260))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($article);
        }

        $manager->flush();
    }
}

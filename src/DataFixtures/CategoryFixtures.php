<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public const NB_CATEGORIES = 25;
    public const CATEGORY_REF_PREFIX = 'category_';

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($faker->words(2, true));
            $manager->persist($category);
            $this->addReference(self::CATEGORY_REF_PREFIX . $i, $category);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $adminEmail;
    private $passwordHasher;

    public function __construct(
        string $adminEmail,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->adminEmail = $adminEmail;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail($this->adminEmail)
            ->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            "12345"
        ));

        $manager->persist($user);
        $manager->flush();

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

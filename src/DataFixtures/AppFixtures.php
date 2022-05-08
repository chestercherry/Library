<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public const OBJECT_COUNT = 10;

    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->loadBooks($manager);
        $this->loadAuthors($manager);
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function loadBooks(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::OBJECT_COUNT; $i++) {

        }
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function loadAuthors(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::OBJECT_COUNT; $i++) {
            $author = new Author();
            $author->setFirstName($this->faker->firstName);
            $author->setLastName($this->faker->lastName);
            $manager->persist($author);
            $manager->flush();
        }
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
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
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function loadBooks(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::OBJECT_COUNT; $i++) {
            $book = new Book();
            $book
                ->setTitle($this->faker->title)
                ->setDescriprion($this->faker->text(200))
                ->setImage($this->faker->imageUrl())
                ->setTime($this->faker->time());

            $manager->persist($book);

            $author = new Author();
            $author
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->addBook($book);

            $manager->persist($author);
            $manager->flush();
        }
    }
}
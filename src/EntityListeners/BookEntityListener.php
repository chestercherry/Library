<?php

namespace App\EntityListeners;

use App\Entity\Book;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class BookEntityListener
{
    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Book) {
            return;
        }

        $entityManager = $args->getObjectManager();

        foreach ($entity->getAuthors() as $author) {
            $author->increasedBookCount();
            $entityManager->persist($author);
        }

        $entityManager->flush();

    }
}
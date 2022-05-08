<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\ApiCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private ApiCrudService $apiCrudService;

    /**
     * @param ApiCrudService $apiCrudService
     */
    public function __construct(ApiCrudService $apiCrudService)
    {
        $this->apiCrudService = $apiCrudService;
        $apiCrudService->setEntityClass(Book::class);
        $apiCrudService->setType("json");
    }

    /**
     * @Route("/book", name="app_book")
     */
    public function index(): Response
    {
        $books = $this->apiCrudService->readAll();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}

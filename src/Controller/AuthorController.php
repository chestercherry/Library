<?php

namespace App\Controller;

use App\Entity\Author;
use App\Service\ApiCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private ApiCrudService $apiCrudService;

    /**
     * @param ApiCrudService $apiCrudService
     */
    public function __construct(ApiCrudService $apiCrudService)
    {
        $this->apiCrudService = $apiCrudService;
        $apiCrudService->setEntityClass(Author::class);
        $apiCrudService->setType("json");
    }

    /**
     * @Route("/author", name="app_author")
     */
    public function index(): Response
    {
        $authors = $this->apiCrudService->readAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }
}

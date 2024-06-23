<?php

namespace App\Controller\Api\V1;

use App\Action\CreateOrUpdateAuthor;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/api/v1/authors', name: 'api.authors.index', methods: ['GET'])]
    public function index(Request $request, AuthorRepository $authorRepository, PaginatorInterface $paginator): JsonResponse
    {
        $pagination = $paginator->paginate(
            $authorRepository->getQueryForPaginator(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->json(
            [
                'data' => $pagination,
                'meta' => [
                    'per_page'     => $pagination->getItemNumberPerPage(),
                    'current_page' => $pagination->getCurrentPageNumber(),
                    'total_items'  => $pagination->getTotalItemCount(),
                ]
            ]
        );
    }

    #[Route('/api/v1/authors', name: 'api.authors.store', methods: ['POST'])]
    public function store(Request $request, CreateOrUpdateAuthor $createOrUpdateAuthor): JsonResponse
    {
        return $this->json($createOrUpdateAuthor->handle(new Author(), $request));
    }

    #[Route('/api/v1/authors/{id}', name: 'api.books.show', methods: ['GET'])]
    public function show(Author $author): JsonResponse
    {
        return $this->json($author);
    }

    #[Route('/api/v1/authors/{id}', name: 'api.books.show', methods: ['PATCH'])]
    public function update(Author $author, Request $request, CreateOrUpdateAuthor $createOrUpdateAuthor): JsonResponse
    {
        return $this->json($createOrUpdateAuthor->handle($author, $request));
    }
}

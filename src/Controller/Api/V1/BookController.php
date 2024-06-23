<?php

namespace App\Controller\Api\V1;

use App\Action\CreateOrUpdateBook;
use App\Entity\Book;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/api/v1/books', name: 'api.books.index', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): JsonResponse
    {
        $pagination = $paginator->paginate(
            $bookRepository->getQueryForPaginator($request->query->get('search')),
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

    #[Route('/api/v1/books', name: 'api.books.store', methods: ['POST'])]
    public function store(Request $request, CreateOrUpdateBook $createOrUpdateBook): JsonResponse
    {
        return $this->json($createOrUpdateBook->handle(new Book(), $request));
    }

    #[Route('/api/v1/books/{id}', name: 'api.books.show', methods: ['GET'])]
    public function show(Book $book): JsonResponse
    {
        return $this->json($book);
    }

    #[Route('/api/v1/books/{id}', name: 'api.books.show', methods: ['PATCH'])]
    public function update(Book $book, Request $request, CreateOrUpdateBook $createOrUpdateBook): JsonResponse
    {
        return $this->json($createOrUpdateBook->handle($book, $request));
    }
}

<?php

namespace App\Action;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;

readonly class CreateOrUpdateAuthor
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    public function handle(Author $author, Request $request): Author
    {
        $author->setName($request->request->get('name'));
        $author->setSurname($request->request->get('surname'));
        $author->setLastName($request->request->get('last_name'));

        $this->authorRepository->add($author, true);

        return $author;
    }
}
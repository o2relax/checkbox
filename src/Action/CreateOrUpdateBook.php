<?php

namespace App\Action;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

readonly class CreateOrUpdateBook
{
    public function __construct(private BookRepository $bookRepository, private AuthorRepository $authorRepository, private FileUploader $fileUploader)
    {
    }

    public function handle(Book $book, Request $request): Book
    {
        $book->setTitle($request->request->get('title'));
        $book->setDescription($request->request->get('description'));
        foreach($request->get('authors', []) as $authorId) {
            if ($author = $this->authorRepository->find($authorId)) {
                $book->addAuthor($author);
            }
        }

        $file = $request->files->get('file');

        if ($file) {
            if ($book->getCover()) {
                $this->fileUploader->remove($book->getCover());
            }
            $book->setCover($this->fileUploader->upload($file));
        }

        $this->bookRepository->add($book, true);

        return $book;
    }
}
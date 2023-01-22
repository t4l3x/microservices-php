<?php

namespace App\Service;

use App\Entity\Authors;
use App\Entity\Books;
use App\Repository\AuthorsRepository;
use App\Repository\BooksRepository;
use Common\DTO\BookDTO;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private BooksRepository $bookRepository;
    private AuthorsRepository $authorRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(BooksRepository $bookRepository, AuthorsRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function saveBook(BookDTO $bookDTO)
    {
        $this->entityManager->beginTransaction();

        try {
            $book = new Books();
            $book->setTitle($bookDTO->getTitle());
            $book->setPages($bookDTO->getPages());
            $book->setReleaseDate($bookDTO->getReleaseDate());

            $author = new Authors();
            $author->setName($bookDTO->getAuthor());
            $this->entityManager->persist($author);


            $book->setAuthor($author);

            $this->bookRepository->save($book);

            $this->entityManager->commit();

        } catch (\Exception $e) {

            $this->entityManager->rollback();
            throw $e;
        }
    }
}
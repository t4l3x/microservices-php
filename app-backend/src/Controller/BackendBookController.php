<?php
namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendBookController extends AbstractController
{
    private BooksRepository $bookRepository;

    public function __construct(BooksRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    /**
     * @Route("/books", name="books", methods={"GET"})
     */
    public function books(SerializerInterface $serializer): Response
    {
        $books = $this->bookRepository->findAllOrderedByReleaseDate();

        $data = $serializer->serialize($books, 'json');


        return new JsonResponse(json_decode($data), 200, []);
    }
}
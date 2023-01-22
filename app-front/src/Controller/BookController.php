<?php

namespace App\Controller;

use Common\DTO\BookDTO;
use App\Handler\BookHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/**
 * @Route("/books", name="books_")
 */
class BookController extends AbstractController
{
    private BookHandler $bookService;
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface  $client, string $secondAppUrl, BookHandler $bookService)
    {
        $this->bookService = $bookService;
        $this->client = $client;
        $this->secondAppUrl = $secondAppUrl;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function createBook(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $dto = new BookDTO();
        $dto->setTitle($data['title']);
        $dto->setAuthor($data['author']);
        $dto->setPages($data['pages']);
        $dto->setReleaseDate($data['releaseDate']);

        $validator = Validation::createValidator();
        $violations = $validator->validate($dto);

        if (count($violations) > 0) {
            // return error response
            return new JsonResponse(['message' => (string) $violations], 400);
        }

        $this->bookService->createBook($dto);
        return new JsonResponse(['message' => 'Book created successfully'], 201);
    }


    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(): JsonResponse
    {
        $response = $this->client->request('GET', $this->secondAppUrl.'/books');
        $books = json_decode($response->getContent(), true);

        return new JsonResponse(['data' => $books], 200);

    }
}
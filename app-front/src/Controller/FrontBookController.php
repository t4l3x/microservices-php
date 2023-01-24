<?php

namespace App\Controller;

use Common\DTO\BookDTO;
use App\Handler\BookHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/**
 * @Route("/books", name="books_")
 */
class FrontBookController extends AbstractController
{
    private BookHandler $bookService;
    private HttpClientInterface $client;
    private SerializerInterface $serializer;
    private string $secondAppUrl;

    public function __construct(HttpClientInterface  $client, string $secondAppUrl, BookHandler $bookService, SerializerInterface  $serializer)
    {
        $this->bookService = $bookService;
        $this->client = $client;
        $this->secondAppUrl = $secondAppUrl;
        $this->serializer = $serializer;
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function createBook(Request $request, ValidatorInterface $validator): JsonResponse
    {
        /** @todo
         *  Create DTO Serializer service
         */
        $dto = $this->serializer->deserialize($request->getContent(), BookDTO::class, 'json');
        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            // return error response
            return new JsonResponse(['message' => (string) $errors], 400);
        }

        $this->bookService->createBook($dto);
        return new JsonResponse(['message' => 'Book created successfully'], 201);
    }


    /**
     * @Route("", name="list", methods={"GET"})
     * @throws Exception|TransportExceptionInterface
     */
    public function list(): JsonResponse
    {
        $response = $this->client->request('GET', $this->secondAppUrl.'/books');
        try {
            $books = json_decode($response->getContent(), true);
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return new JsonResponse(['data' => $books], 200);

    }
}
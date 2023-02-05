<?php

namespace App\Tests\unit\Controller;

use App\Controller\FrontBookController;
use App\Handler\BookHandler;
use Common\DTO\BookDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FrontBookControllerTest  extends \Codeception\Test\Unit
{
    private BookHandler $bookService;
    private HttpClientInterface $client;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private FrontBookController $controller;
    private Request $request;

    public function _before(): void
    {
        $this->bookService = $this->createMock(BookHandler::class);
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->controller = new FrontBookController($this->client, 'secondAppUrl', $this->bookService, $this->serializer);
        $this->request = $this->createMock(Request::class);
    }

    public function testCreateBookMethod(): void
    {
        $dto = $this->createMock(BookDTO::class);

        $this->request->method('getContent')->willReturn('');
        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->with($this->request->getContent(), BookDTO::class, 'json')
            ->willReturn($dto);

        $constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);
        $this->validator->expects($this->once())
            ->method('validate')
            ->with($dto)
            ->willReturn($constraintViolationList);

        $this->bookService->expects($this->once())
            ->method('createBook')
            ->with($dto);

        $response = $this->controller->createBook($this->request, $this->validator);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertEquals(['message' => 'Book created successfully'], $content);
        $this->assertEquals(201, $response->getStatusCode());

    }

    public function testListMethod(): void
    {
        $expectedBooks = [
            [
                'id' => '018621b9-d781-78bb-8614-563152e13a30',
                'title' => 'Test Book',
                'pages' => 13,
                'release_date' => '2022-12-10T00:00:00+00:00',
                'author' => 'Test Author',
            ],
        ];

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($expectedBooks, JSON_THROW_ON_ERROR));

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'secondAppUrl/books')
            ->willReturn($responseMock);

        $response = $this->controller->list();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $content = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertEquals(['data' => $expectedBooks], $content);
        $this->assertEquals(200, $response->getStatusCode());
    }

}
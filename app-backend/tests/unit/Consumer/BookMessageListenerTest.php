<?php
namespace App\Tests\Unit\Consumer;

use App\Consumer\BookMessageListener;
use App\Entity\Authors;
use App\Entity\Books;
use App\Message\BookMessage;
use App\Repository\AuthorsRepository;
use App\Service\BookService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;

class BookMessageListenerTest extends TestCase
{
    /**
     * @var AuthorsRepository|MockObject
     */
    private MockObject|AuthorsRepository $authorRepository;

    /**
     * @var BookService|MockObject
     */
    private MockObject|BookService $bookService;

    /**
     * @var BookMessageListener
     */
    private $bookMessageListener;

    public function setUp(): void
    {
        $this->authorRepository = $this->createMock(AuthorsRepository::class);
        $this->bookService = $this->createMock(BookService::class);
        $this->bookMessageListener = new BookMessageListener($this->authorRepository, $this->bookService);
    }

    public function testConsumeBookMessage()
    {
        // Create a dummy book message
        $bookMessage = new BookMessage('Test Title', 'Test Author', 100, '2022-01-01');
        $envelope = new Envelope($bookMessage);

        // Create a dummy author and book entity
        $author = new Authors();
        $author->setName('Test Author');
        $book = new Books();
        $book->setTitle('Test Title');
        $book->setPages(100);
        $book->setReleaseDate(new \DateTime('2022-01-01'));
        $book->setAuthor($author);

        // Expect the author repository to return the dummy author when findOneByName is called
        $this->authorRepository->expects($this->once())
            ->method('findOneByName')
            ->with('Test Author')
            ->willReturn($author);

        // Expect the book service to be called with the dummy book and author
        $this->bookService->expects($this->once())
            ->method('createOrUpdateBook')
            ->with($book, $author);

        // Consume the dummy book message
        $this->bookMessageListener->__invoke($envelope);

        // Assertions to check that the message was consumed correctly
        // For example, you could check that the book service's createOrUpdateBook method was called once
        $this->bookService->verify();
    }

}
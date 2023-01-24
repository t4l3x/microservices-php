<?php
namespace App\Tests\Unit\Consumer;

use App\Consumer\BookMessageListener;
use App\Service\BookService;
use Common\DTO\BookDTO;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;

class BookMessageListenerTest extends TestCase
{
    /**
     * @var BookMessageListener
     */
    private BookMessageListener $bookMessageListener;


    public function setUp(): void
    {
        parent::setup();
        $bookService = $this->createMock(BookService::class);
        $this->bookMessageListener = new BookMessageListener($bookService);
    }

    /**
     * @throws Exception
     */
    public function testConsumeBookMessage()
    {
        // Create a fake book DTO
        $bookDTO = new BookDTO();
        $bookDTO->setTitle('Test Title');
        $bookDTO->setAuthor('Test Author');
        $bookDTO->setPages(100);
        $bookDTO->setReleaseDate(new \DateTime('2022-01-01'));
        $envelope = new Envelope($bookDTO);


        // Extract the message from the envelope
        $message = $envelope->getMessage();

        // Assert that the message is an instance of BookDTO
        $this->assertInstanceOf(BookDTO::class, $message);

        // Consume the fake book message
        $this->bookMessageListener->__invoke($message);
    }

}
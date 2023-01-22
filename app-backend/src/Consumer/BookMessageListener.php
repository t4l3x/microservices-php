<?php

namespace App\Consumer;

use App\Service\BookService;
use Common\DTO\BookDTO;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class BookMessageListener
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(BookDTO $bookDTO): void
    {
        $this->bookService->saveBook($bookDTO);
    }
}

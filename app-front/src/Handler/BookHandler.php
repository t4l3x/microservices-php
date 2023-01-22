<?php

namespace App\Handler;
use Common\DTO\BookDTO;
use Symfony\Component\Messenger\MessageBusInterface;

class BookHandler
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function createBook(BookDTO $dto): void
    {
        $this->bus->dispatch($dto);
    }
}
<?php

namespace App\Command;
use Common\DTO\BookDTO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendBookMessageCommand extends Command
{
    protected static $defaultName = 'app:send-book-message';
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send a book message.')
            ->addArgument('title', InputArgument::REQUIRED, 'The title of the book.')
            ->addArgument('author', InputArgument::REQUIRED, 'The author of the book.')
            ->addArgument('pages', InputArgument::REQUIRED, 'The number of pages in the book.')
            ->addArgument('releaseDate', InputArgument::REQUIRED, 'The release date of the book.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $title = $input->getArgument('title');
        $author = $input->getArgument('author');
        $pages = $input->getArgument('pages');
        $releaseDate = $input->getArgument('releaseDate');

        $dto = new BookDTO();
        $dto->setTitle($title);
        $dto->setAuthor($author);
        $dto->setPages($pages);
        $dto->setReleaseDate($releaseDate);

        $this->bus->dispatch($dto);
        $output->writeln(sprintf('Book message sent: %s', $title));
    }
}
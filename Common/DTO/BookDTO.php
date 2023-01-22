<?php

namespace Common\DTO;

use DateTime;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BookDTO
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=30)
     */
    public string $title;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=30)
     */
    public string $author;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min=0, max=1000)
     */
    public int $pages;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    public DateTimeInterface $releaseDate;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return BookDTO
     */
    public function setTitle(string $title): BookDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return BookDTO
     */
    public function setAuthor(string $author): BookDTO
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     * @return BookDTO
     */
    public function setPages(int $pages): BookDTO
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return ?DateTimeInterface
     */
    public function getReleaseDate(): ?DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @param ?string $releaseDate
     * @return BookDTO
     */
    public function setReleaseDate(?string $releaseDate): BookDTO
    {

        $this->releaseDate = DateTime::createFromFormat('d-m-Y',$releaseDate);
        return $this;
    }
}

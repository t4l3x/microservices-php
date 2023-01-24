<?php

namespace Common\DTO;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BookDTO
{
    /**
     * @Assert\Length(max=30)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9\.]+$/",
     *     message="Title can only contain letters, numbers, and periods"
     * )
     */
    private string $title;

    /**
     * @Assert\Length(max=30)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9\.]+$/",
     *     message="Title can only contain letters, numbers, and periods"
     * )
     */
    private string $author;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min=0, max=1000)
     */
    private int $pages;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min="-100 years", max="+100 years")
     */
    private ?DateTimeInterface $releaseDate;

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
     * @param string $pages
     * @return BookDTO
     */
    public function setPages(string $pages): BookDTO
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
     * @param ?DateTimeInterface $releaseDate
     * @return BookDTO
     */
    public function setReleaseDate(?DateTimeInterface $releaseDate): BookDTO
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }
}

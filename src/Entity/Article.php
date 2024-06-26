<?php

namespace App\Entity;

use DateTime;
use InvalidArgumentException;

class Article
{
    private string $guid;
    private string $title;
    private string $link;
    private string $description;
    private array $category;


    /**
     * @param string $guid
     * @param string $title
     * @param string $link
     * @param string $description
     * @param array $category
     */
    public function __construct(string $guid, string $title, string $link, string $description, array $category)
    {
        preg_match('/(?<=p=)\d+/', $guid, $match) ? $this->guid = $match[0] : throw new InvalidArgumentException("Wrong guid");
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->category = $category;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): array
    {
        return $this->category;
    }
}
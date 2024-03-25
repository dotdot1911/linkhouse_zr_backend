<?php

namespace App\Entity;

use DateTime;
use InvalidArgumentException;

class Article
{
    private string $title;
    private string $link;
    private string $pubDate;
    private array $category;
    private string $guid;
    private string $description;

    /**
     * @param string $title
     * @param string $link
     * @param string $pubDate
     * @param array $category
     * @param string $guid
     * @param string $description
     */
    public function __construct(string $title, string $link, string $pubDate, array $category, string $guid, string $description)
    {
        $this->title = $title;
        $this->link = $link;
        $this->pubDate = DateTime::createFromFormat('D, d M Y H:i:s O', $pubDate)->format('Y-m-d H:i:s');
        $this->category = $category;
        preg_match('/(?<=p=)\d+/', $guid, $match) ? $this->guid = $match[0] : throw new InvalidArgumentException("Wrong guid");

        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
<?php

namespace App\Entity;

use DateTime;
use InvalidArgumentException;

class ArticleList
{
    private string $guid;
    private string $title;
    private string $pubDate;
    private array $category;


    /**
     * @param string $guid
     * @param string $title
     * @param string $pubDate
     * @param array $category
     */
    public function __construct(string $guid, string $title, string $pubDate, array $category)
    {
        preg_match('/(?<=p=)\d+/', $guid, $match) ? $this->guid = $match[0] : throw new InvalidArgumentException("Wrong guid");
        $this->title = $title;
        $this->pubDate = DateTime::createFromFormat('D, d M Y H:i:s O', $pubDate)->format('Y-m-d H:i:s');
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

    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    public function getCategory(): array
    {
        return $this->category;
    }
}
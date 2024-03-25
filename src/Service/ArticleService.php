<?php

namespace App\Service;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use App\Entity\Article;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class ArticleService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function getArticlesListFromXML($url): array
    {
        $xmlContent = file_get_contents($url);
        $xml = simplexml_load_string($xmlContent);
        $articleArray = [];
        $categoryArray = [];
        foreach ($xml->channel->item as $item) {
            try {
                foreach ($item->category as $itemCategory) {
                    $categoryArray[] = (string)$itemCategory;
                }
                $articleArray[] = new Article((string)$item->title, (string)$item->link, (string)$item->pubDate, $categoryArray, (string)$item->guid, (string)$item->description);
                $categoryArray = [];
            } catch (InvalidArgumentException $e) {
                $this->logger->warning($e->getMessage() . "\n");
            }

        }
        return $articleArray;
    }

    public function getArticleFromXML($url, $guid): Article|null
    {
        $xmlContent = file_get_contents($url);
        $xml = simplexml_load_string($xmlContent);
        $categoryArray = [];
        foreach ($xml->channel->item as $item) {
            try {
                preg_match('/(?<=p=)\d+/', (string)$item->guid, $match);
                if ($match[0] == $guid) {
                    foreach ($item->category as $itemCategory) {
                        $categoryArray[] = (string)$itemCategory;
                    }
                    return new Article((string)$item->title, (string)$item->link, (string)$item->pubDate, $categoryArray, (string)$item->guid, (string)$item->description);
                }
            } catch (InvalidArgumentException $e) {
                $this->logger->warning($e->getMessage() . "\n");
            }
        }
        return null;
    }
}
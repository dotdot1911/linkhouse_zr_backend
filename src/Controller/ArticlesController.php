<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;


class ArticlesController extends AbstractController
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('/articles', name: 'app_articles')]
    public function indexAction(): JsonResponse
    {
        $articleList = $this->articleService->getArticlesListFromXML("https://linkhouse.pl/feed/");
        return $this->json($articleList);
    }

    #[Route('/article/{guid}', name: 'app_article')]
    public function detailsAction(string $guid): JsonResponse
    {
        $article = $this->articleService->getArticleFromXML("https://linkhouse.pl/feed/", $guid);
        return $this->json($article);
    }
}

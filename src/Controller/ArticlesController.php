<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class ArticlesController extends AbstractController
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('/articles', name: 'app_articles')]
    public function indexAction(Request $request): JsonResponse
    {
        $lang = $request->query->get('lang');
        if ($lang == "en")
        {
            $articleList = $this->articleService->getArticlesListFromXML("https://linkhouse.net/feed/");
        }
        else
        {
            $articleList = $this->articleService->getArticlesListFromXML("https://linkhouse.pl/feed/");
        }
        
        return $this->json($articleList);
    }

    #[Route('/article/{guid}', name: 'app_article')]
    public function detailsAction(Request $request, string $guid): JsonResponse
    {
        $lang = $request->query->get('lang');
        if ($lang == "en") {
            $article = $this->articleService->getArticleFromXML("https://linkhouse.net/feed/", $guid);
        }
        else {
            $article = $this->articleService->getArticleFromXML("https://linkhouse.pl/feed/", $guid);
        }
        return $this->json($article);
    }
}

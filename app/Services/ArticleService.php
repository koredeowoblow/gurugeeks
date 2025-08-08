<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\SourceRepository;
use jcobhams\NewsApi\NewsApi;
use Illuminate\Support\Facades\Log;

class ArticleService
{
    protected $articleRepository;
    protected $authorRepository;
    protected $sourceRepository;
    protected $newsapi;

    public function __construct(
        ArticleRepository $articleRepository,
        AuthorRepository $authorRepository,
        SourceRepository $sourceRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
        $this->sourceRepository = $sourceRepository;

        // Initialize NewsApi with your key
        $your_api_key = "b5e781aa73d449c4a0917a58871df2ec"; // or use env('NEWSAPI_KEY')
        $this->newsapi = new NewsApi($your_api_key);
    }

    /**
     * Fetch and return articles from NewsAPI (optionally save them).
     */
    public function createArticle(array $data)
    {
        $articles = $this->newsapi->getEverything();

        $savedArticles = $this->articleRepository->saveArticlesToDb($articles);
        if (empty($savedArticles)) {
            Log::info('No articles saved.');
            return [];
        }

        return $articles;
    }

    /**
     * Return all available categories.
     */
    public function getCategory()
    {
        return $this->newsapi->getCategories();
    }

    /**
     * Return top headlines by preferred categories.
     */
    public function getArticlesByUserPreferences(array $preferredCategories = ['general'])
    {
        $newsData = [];

        foreach ($preferredCategories as $category) {
            try {
                $response = $this->newsapi->getTopHeadLines(
                    null,   // query (optional)
                    null,   // sources
                    null,   // country
                    $category,
                    5       // pageSize
                );

                $newsData[$category] = ($response->status === 'ok')
                    ? $response->articles
                    : [];
            } catch (\Exception $e) {
                $newsData[$category] = ['error' => $e->getMessage()];
            }
        }

        return $newsData;
    }
}

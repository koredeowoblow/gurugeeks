<?php

namespace App\Http\Controllers;

use App\Class\ApiResponse;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * Create a new class instance.
     */
    protected $articleService;
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        // Logic to retrieve and display articles
        $articles = $this->articleService->createArticle(request()->all());
        return ApiResponse::success('Articles retrieved successfully', $articles);
    }

    public function getCategory()
    {
        $category = $this->articleService->getCategory();
        return ApiResponse::success("category retrieved successfully", $category);
    }
    public function getPersonalizedNews(Request $request)
    {
        $user = $request->user();

        $categories = $user->categories()->pluck('name')->toArray();
        if (empty($categories)) {
            $categories = ['general'];
        }
        $news = $this->articleService->getArticlesByUserPreferences($categories);
        $data = [
            'preferences' => $categories,
            'news' => $news
        ];
        return ApiResponse::success("Article retrieved successfully", $data);
    }
}

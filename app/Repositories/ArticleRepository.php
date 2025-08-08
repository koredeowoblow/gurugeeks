<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Str;
use App\Repositories\AuthorRepository;
use App\Repositories\SourceRepository;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{
    protected $AuthorRepository;
    protected $SourceRepository;

    public function __construct(AuthorRepository $authorRepository, SourceRepository $sourceRepository)
    {
        $this->AuthorRepository = $authorRepository;
        $this->SourceRepository = $sourceRepository;
    }

    public function saveArticlesToDb($response): array
    {
        $saved = [];
        $skipped = [];

        if (
            isset($response->status) &&
            $response->status === 'ok' &&
            !empty($response->articles)
        ) {
            foreach ($response->articles as $index => $item) {
                $step = "Article " . ($index + 1);

                // STEP 1: Extract names
                $authorName = $item->author ?? 'Unknown Author';
                $sourceName = $item->source->name ?? 'Unknown Source';
                Log::info($sourceName);
                // STEP 2: Check if source already exists
                $existingSource = $this->SourceRepository->getSourceByName($sourceName);
                if ($existingSource) {
                    $skipped[] = "$step - Source '$sourceName' already exists. Skipping.";
                    continue;
                }
                $sources = [
                    'name' => $sourceName,
                    'url' => $item->url,
                ];

                // STEP 3: Create source
                $source = $this->SourceRepository->createSource($sources);

                // STEP 4: Create or get author
                $authors = [
                    'name'      => $authorName,
                    'source_id' => $source->id,
                ];
                $existingAuthor = $this->AuthorRepository->getAuthorByName($authorName);
                if ($existingAuthor) {
                    $skipped[] = "$step - Author '$authorName' already exists. Skipping.";
                    continue;
                }
                // Create a new author if not found
                $author = $this->AuthorRepository->createAuthor($authors);

                // STEP 5: Generate unique slug
                $slug = Str::slug($item->title);
                $originalSlug = $slug;
                $counter = 1;
                while (Article::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                // STEP 6: Save article
                $data = [
                    'title'      => $item->title,
                    'content'    => $item->content ?? null,
                    'slug'       => $slug,
                    'author_id'  => $author->id,
                    'source_id'  => $source->id,
                    'user_id'    => 1, // default user
                ];
                $this->create($data); // assumes you have a create() method in repo

                $saved[] = "$step - Article '{$item->title}' saved successfully.";
            }

            return [
                'status' => 'done',
                'saved' => $saved,
                'skipped' => $skipped,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid or empty response.',
        ];
    }

    public function getAllArticles(): array
    {
        return Article::with(['author', 'source'])->get()->toArray();
    }
    public function getArticleById(int $id): ?Article
    {
        return Article::with(['author', 'source'])->find($id);
    }
    public function updateArticle(int $id, array $data): ?Article
    {
        $article = Article::find($id);
        if ($article) {
            $article->update($data);
            return $article;
        }
        return null;
    }
    public function create(array $data): Article
    {
        return Article::create($data);
    }
}

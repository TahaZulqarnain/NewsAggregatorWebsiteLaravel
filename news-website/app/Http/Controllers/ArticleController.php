<?php

namespace App\Http\Controllers;
use App\Services\ArticleService;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(private ArticleService $articleService) {}

    public function index(ArticleRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 10;

        $articles = $this->articleService->getFilteredArticles($filters, $perPage);
          return response()->json([
            'count' => $articles->count(),
            'total' => $articles->total(),
            'data' => ArticleResource::collection($articles)->resolve()
        ]);
    }

    public function show($id)
    {
        $articles = $this->articleService->find($id);
        return new ArticleResource($articles);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $query = Article::with('author')->latest();
        $user = request()->user();

        if (! $user->isAdmin()) {
            $query->where('author_id', $user->id);
        }

        return view('manage.articles.index', ['articles' => $query->paginate(10)]);
    }

    public function create()
    {
        return view('manage.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        Article::create([
            ...$validated,
            'author_id' => $request->user()->id,
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'excerpt' => Str::limit(strip_tags($validated['body']), 160),
            'published_at' => now(),
        ]);

        return redirect()->route('manage.articles.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        $this->authorizeArticle($article, request());

        return view('manage.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorizeArticle($article, $request);
        $validated = $this->validated($request);
        $article->update([
            ...$validated,
            'excerpt' => Str::limit(strip_tags($validated['body']), 160),
        ]);

        return redirect()->route('manage.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->authorizeArticle($article, request());
        $article->delete();

        return redirect()->route('manage.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'min:40'],
            'cover_path' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function authorizeArticle(Article $article, Request $request): void
    {
        abort_unless($request->user()->isAdmin() || $article->author_id === $request->user()->id, 403);
    }
}

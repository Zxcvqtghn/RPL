<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Log;
use Throwable;

class LandingController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::with('author')->latest('published_at')->take(3)->get();
            $testimonials = Testimonial::query()->where('is_featured', true)->latest()->take(4)->get();
        } catch (Throwable $exception) {
            Log::error('Landing content query failed.', [
                'message' => $exception->getMessage(),
                'exception' => $exception::class,
            ]);

            $articles = collect();
            $testimonials = collect();
        }

        return view('landing.index', [
            'articles' => $articles,
            'testimonials' => $testimonials,
        ]);
    }

    public function article(Article $article)
    {
        return view('landing.article', compact('article'));
    }
}

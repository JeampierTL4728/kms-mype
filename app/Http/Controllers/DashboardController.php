<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Attachment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Métricas Generales
        $totalArticles = Article::where('status', 'published')->count();
        $totalViews = Article::sum('views');
        $totalAttachments = Attachment::count();

        // Top 5 artículos más consultados
        $topArticles = Article::with('category')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Distribución de artículos por categoría
        $categoriesStats = Category::withCount('articles')->get();

        return view('dashboard', compact(
            'totalArticles',
            'totalViews',
            'totalAttachments',
            'topArticles',
            'categoriesStats'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category', 'attachments')->where('status', 'published');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $articles = $query->latest()->get();
        $categories = Category::all();

        return view('welcome', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'youtube_url' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,txt,docx,zip|max:10240',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => 'published',
            'views' => 0,
        ]);

        // Procesar subida de archivo o URL de YouTube
        if ($request->hasFile('file') || $request->filled('youtube_url')) {
            $filePath = null;
            $fileType = null;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('attachments', 'public');
                $fileType = $request->file('file')->getClientOriginalExtension();
            }

            $article->attachments()->create([
                'file_path' => $filePath,
                'file_type' => $fileType,
                'youtube_url' => $request->youtube_url,
            ]);
        }

        return redirect()->route('articles.index')->with('success', '¡Artículo y adjuntos registrados con éxito!');
    }

    public function show($id)
    {
        $article = Article::with('category', 'attachments')->findOrFail($id);
        $article->increment('views');

        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::with('attachments')->findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'youtube_url' => 'nullable|url',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,txt,docx,zip|max:10240',
        ]);

        $article->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
        ]);

        if ($request->hasFile('file') || $request->filled('youtube_url')) {
            $filePath = null;
            $fileType = null;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('attachments', 'public');
                $fileType = $request->file('file')->getClientOriginalExtension();
            }

            $article->attachments()->create([
                'file_path' => $filePath,
                'file_type' => $fileType,
                'youtube_url' => $request->youtube_url,
            ]);
        }

        return redirect()->route('articles.show', $article->id)->with('success', '¡Artículo actualizado correctamente!');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        // Eliminar archivos físicos asociados
        foreach ($article->attachments as $attachment) {
            if ($attachment->file_path) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artículo eliminado correctamente.');
    }
}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - KMS MYPE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('articles.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver al Centro de Soluciones
            </a>

            <!-- Acciones: Editar / Eliminar -->
            <div class="flex items-center gap-2">
                <a href="{{ route('articles.edit', $article->id) }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-to-square"></i> Editar
                </a>
                
                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este artículo?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <article class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $article->category->name }}
                </span>
                <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                    <i class="fa-regular fa-eye"></i> {{ $article->views }} vistas
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            <div class="prose max-w-none text-slate-700 leading-relaxed space-y-4 border-t border-slate-100 pt-6 whitespace-pre-line">
                {{ $article->content }}
            </div>

            @if($article->attachments->count() > 0)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-paperclip text-blue-600"></i> Recursos y Adjuntos de Ayuda
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($article->attachments as $attachment)
                            @if($attachment->file_path)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-blue-50 hover:border-blue-200 transition-all flex items-center gap-3 group">
                                    <div class="p-3 bg-white rounded-lg text-blue-600 border border-slate-200 group-hover:border-blue-300 shadow-sm">
                                        <i class="fa-solid fa-file-arrow-down text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm group-hover:text-blue-700">Descargar Archivo Adjunto</p>
                                        <p class="text-xs text-slate-500 uppercase">Formato: {{ $attachment->file_type ?? 'Documento' }}</p>
                                    </div>
                                </a>
                            @endif

                            @if($attachment->youtube_url)
                                <a href="{{ $attachment->youtube_url }}" target="_blank" class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-rose-50 hover:border-rose-200 transition-all flex items-center gap-3 group">
                                    <div class="p-3 bg-white rounded-lg text-rose-600 border border-slate-200 group-hover:border-rose-300 shadow-sm">
                                        <i class="fa-brands fa-youtube text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm group-hover:text-rose-700">Ver Video Instructivo</p>
                                        <p class="text-xs text-slate-500">Abrir en YouTube</p>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </article>
    </div>
</body>
</html>
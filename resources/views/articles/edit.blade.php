<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo - KMS MYPE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ route('articles.show', $article->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i> Volver al detalle
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-600"></i> Editar Procedimiento de Soporte
            </h1>

            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block font-semibold text-slate-700 mb-2">Título de la Solución / Problema:</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label for="category_id" class="block font-semibold text-slate-700 mb-2">Módulo / Rubro MYPE:</label>
                    <select id="category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="content" class="block font-semibold text-slate-700 mb-2">Procedimiento Detallado (Paso a Paso):</label>
                    <textarea id="content" name="content" rows="6" required class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 space-y-4">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-paperclip text-slate-500"></i> Adjuntar Nuevos Recursos (Opcional)
                    </h3>
                    
                    <div>
                        <label for="file" class="block text-sm font-medium text-slate-600 mb-1">Subir Archivo (.pdf, .png, .txt, .docx, .zip):</label>
                        <input type="file" id="file" name="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>

                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-slate-600 mb-1">Enlace de Video (YouTube):</label>
                        <input type="url" id="youtube_url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('articles.show', $article->id) }}" class="px-5 py-2.5 rounded-lg border border-slate-300 font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Cancelar</a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm transition-all">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS MYPE - Centro de Soluciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Header Navigation -->
<!-- Header Navigation -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-600 rounded-xl text-white shadow-lg">
                    <i class="fa-solid fa-headset text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">KMS MYPE</h1>
                    <p class="text-xs text-slate-400">Sistema de Gestión del Conocimiento para Soporte Técnico</p>
                </div>
            </div>
            
            <!-- Botones de Navegación -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm rounded-xl border border-slate-700 transition-all">
                    <i class="fa-solid fa-chart-line"></i> Métricas
                </a>
                <a href="{{ route('articles.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow transition-all">
                    <i class="fa-solid fa-plus"></i> Nuevo Artículo
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Panel de Búsqueda -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
            <form action="{{ route('articles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400"></i>
                    <input type="text" name="search" placeholder="Buscar por solución, software o palabras clave (ej. AnyDesk)..." value="{{ request('search') }}" class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm">
                </div>

                <div class="md:col-span-4 relative">
                    <i class="fa-solid fa-filter absolute left-4 top-3.5 text-slate-400"></i>
                    <select name="category_id" class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm appearance-none bg-white">
                        <option value="">-- Todos los Módulos --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-sm transition-all shadow-sm">
                        Buscar
                    </button>
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('articles.index') }}" class="px-3 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm flex items-center justify-center transition-all" title="Limpiar Filtros">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Encabezado de Resultados -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-book-bookmark text-blue-600"></i> Artículos Registrados 
                <span class="text-xs bg-slate-200 text-slate-700 px-2.5 py-1 rounded-full font-semibold">{{ $articles->count() }}</span>
            </h2>
        </div>

        <!-- Lista de Artículos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $article->category->name }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                <i class="fa-regular fa-eye"></i> {{ $article->views }} vistas
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2 hover:text-blue-600 transition-colors line-clamp-2">
                            <a href="{{ route('articles.show', $article->id) }}">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                            {{ $article->content }}
                        </p>
                    </div>

                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold">
                        <a href="{{ route('articles.show', $article->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            Ver Detalle Paso a Paso <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        @if($article->attachments->count() > 0)
                            <span class="text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-paperclip"></i> Adjuntos
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">No se encontraron artículos</h3>
                    <p class="text-slate-500 text-sm">Intenta ajustar los términos de búsqueda o selecciona otra categoría.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
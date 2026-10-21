<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMS MYPE - Panel de Métricas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Header Navigation -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-600 rounded-xl text-white shadow-lg">
                    <i class="fa-solid fa-chart-line text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">Panel de Métricas del KMS</h1>
                    <p class="text-xs text-slate-400">Indicadores de uso y efectividad de la base de conocimiento</p>
                </div>
            </div>
            <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm rounded-xl border border-slate-700 transition-all">
                <i class="fa-solid fa-arrow-left"></i> Volver al Centro de Soluciones
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 space-y-8">

        <!-- Tarjetas de Métricas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                    <i class="fa-solid fa-newspaper text-3xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Artículos Publicados</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $totalArticles }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <i class="fa-solid fa-eye text-3xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Visualizaciones Totales</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $totalViews }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl">
                    <i class="fa-solid fa-paperclip text-3xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Recursos / Adjuntos</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $totalAttachments }}</p>
                </div>
            </div>
        </div>

        <!-- Sección de Análisis: Top 5 y Gráfico -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Tabla Top 5 Artículos -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-amber-500"></i> Soluciones Más Consultadas
                </h2>

                <div class="space-y-4">
                    @forelse($topArticles as $index => $article)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-blue-50 transition-colors">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <span class="w-7 h-7 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shrink-0">
                                    #{{ $index + 1 }}
                                </span>
                                <div class="truncate">
                                    <a href="{{ route('articles.show', $article->id) }}" class="font-bold text-sm text-slate-800 hover:text-blue-600 truncate block">
                                        {{ $article->title }}
                                    </a>
                                    <span class="text-xs text-slate-500 font-medium">{{ $article->category->name }}</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-700 shrink-0">
                                👁️ {{ $article->views }}
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm text-center py-6">No hay datos registrados aun.</p>
                    @endforelse
                </div>
            </div>

            <!-- Gráfica de Distribución por Rubro -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-blue-600"></i> Cobertura por Rubro MYPE
                </h2>

                <div class="relative flex-1 min-h-[220px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

        </div>

    </main>

    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = {
            labels: {!! json_encode($categoriesStats->pluck('name')) !!},
            datasets: [{
                label: 'Cantidad de Artículos',
                data: {!! json_encode($categoriesStats->pluck('articles_count')) !!},
                backgroundColor: ['#2563eb', '#10b981', '#8b5cf6', '#f59e0b', '#64748b'],
                borderWidth: 0
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: categoryData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Segoe UI', size: 12 },
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
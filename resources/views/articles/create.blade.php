<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Artículo de Soporte - KMS MYPE</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 30px; background-color: #f8fafc; color: #1e293b; }
        .container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .back-link { display: inline-block; margin-bottom: 20px; color: #2563eb; text-decoration: none; font-weight: 600; }
        h1 { color: #0f172a; margin-top: 0; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; color: #334155; }
        input[type="text"], select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        textarea { height: 140px; resize: vertical; }
        .btn { background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 15px; }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('articles.index') }}" class="back-link">← Volver al Centro de Soluciones</a>
        <h1>Registrar Nuevo Procedimiento de Soporte</h1>

        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Título de la Solución / Problema:</label>
                <input type="text" id="title" name="title" placeholder="Ej: Solución a error de conexión en AnyDesk v7.1" required>
            </div>

            <div class="form-group">
                <label for="category_id">Módulo / Rubro MYPE:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Procedimiento Detallado (Paso a Paso):</label>
                <textarea id="content" name="content" placeholder="Escribe aquí los pasos de la solución..." required></textarea>
            </div>

            <div class="form-group">
                <label for="youtube_url">Enlace de Video Instructivo (Opcional - YouTube):</label>
                <input type="text" id="youtube_url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=...">
            </div>

            <button type="submit" class="btn">Guardar Artículo</button>
        </form>
    </div>
</body>
</html>
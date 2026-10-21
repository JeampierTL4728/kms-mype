<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Article;

class KmsDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear las Categorías Principales del Sistema MYPE
        $restaurante = Category::create([
            'name' => 'Restaurante',
            'description' => 'Soluciones para impresión de comanderas, caja y atención vía WhatsApp'
        ]);

        $hotel = Category::create([
            'name' => 'Hotel',
            'description' => 'Configuración de facturación electrónica y check-in/out'
        ]);

        $multirubro = Category::create([
            'name' => 'Multirubro',
            'description' => 'Procedimientos generales de soporte remoto vía AnyDesk y gestión de stock'
        ]);

        // 2. Crear Artículos de Prueba
        Article::create([
            'category_id' => $restaurante->id,
            'title' => 'Configuración de Impresora de Comandas por WhatsApp',
            'content' => 'Pasos para vincular la recepción de pedidos vía WhatsApp con la tiquetera térmica local. Verificar conexión USB o red LAN.',
            'status' => 'published',
            'views' => 12
        ]);

        Article::create([
            'category_id' => $multirubro->id,
            'title' => 'Conexión Remota Segura vía AnyDesk para Atención a PYMEs',
            'content' => 'Procedimiento estándar para solicitar el ID de AnyDesk al cliente, validar credenciales y realizar la actualización remota del sistema.',
            'status' => 'published',
            'views' => 25
        ]);
    }
}

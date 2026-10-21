<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('attachments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('article_id')->constrained()->onDelete('cascade');
        $table->string('file_path')->nullable(); // Ruta del archivo (.exe, .pdf, .png)
        $table->string('file_type')->nullable(); // Extensión o tipo de recurso
        $table->string('youtube_url')->nullable(); // Enlace a video instructivo
        $table->timestamps();
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};

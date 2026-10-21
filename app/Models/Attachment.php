<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'file_path', 'file_type', 'youtube_url'];

    // Un adjunto pertenece a un artículo
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

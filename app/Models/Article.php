<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id', 'status', 'views'];

    // Un artículo pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Un artículo puede tener muchos adjuntos
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}

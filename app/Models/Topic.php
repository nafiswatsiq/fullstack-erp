<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name', 
        'slug', 
        'description', 
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

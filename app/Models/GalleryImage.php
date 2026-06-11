<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = ['filename', 'caption', 'category', 'sort_order', 'is_visible'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::url('gallery/' . $this->filename);
    }

    public function getThumbUrlAttribute(): string
    {
        // Thumbs stored as thumb_{filename}
        $thumb = 'gallery/thumbs/' . $this->filename;
        return Storage::exists($thumb)
            ? Storage::url($thumb)
            : Storage::url('gallery/' . $this->filename);
    }
}

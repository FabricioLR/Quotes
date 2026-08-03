<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'content', 'slug', 'views_count', 'likes_count'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($quote) {
            if (empty($quote->slug)) {
                $quote->slug = Str::slug(Str::limit($quote->content, 40, ''));
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
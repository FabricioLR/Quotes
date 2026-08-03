<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'bio', 'avatar_path'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($author) {
            if (empty($author->slug)) {
                $author->slug = Str::slug($author->name);
            }
        });
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(Category::class, Quote::class);
    }
}
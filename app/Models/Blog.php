<?php

// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'content',
        'published_date',
        'banner_image',
        'slug',
        'tags',
    ];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });

        static::updating(function ($blog) {
            $oldBannerImage = $blog->getOriginal('banner_image');
            if ($oldBannerImage !== $blog->banner_image) {
                Storage::disk('public')->delete($oldBannerImage);
            }
            $blog->slug = $blog->slug; // Preserve the existing slug
        });

        static::deleting(function ($blog) {
            Storage::disk('public')->delete($blog->banner_image);
        });
    }

    public function relatedPosts($limit = 5)
    {
        return Blog::where('id', '!=', $this->id)
                    ->orderBy('published_date', 'desc')
                    ->take($limit)
                    ->get();
    }
    
    // Accessor for tags
    public function getTagsAttribute($value)
    {
        return explode(',', $value);
    }

    // Mutator for tags
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = is_array($value) ? implode(',', $value) : $value;
    }
}

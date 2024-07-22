<?php

// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $relatedPosts = Blog::where('slug', '!=', $slug)->take(5)->get();

        return view('blogs.show', [
            'blog' => $blog,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}

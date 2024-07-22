<?php

// app/Http/Controllers/TagController.php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($tag)
    {
        // Fetch the blogs that contain the specified tag
        $blogs = Blog::where('tags', 'LIKE', "%{$tag}%")->paginate(6); // Adjust the number of items per page as needed

        return view('tags.show', [
            'tag' => $tag,
            'blogs' => $blogs
        ]);
    }
}

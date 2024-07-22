<!-- resources/views/blogs/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-8 lg:mx-24">Blog List</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:mx-24">
            @foreach ($blogs as $blog)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($blog->banner_image) }}" class="w-full h-48 object-cover"
                        alt="{{ $blog->title }}">
                    <div class="p-6">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-xl font-semibold">{{ $blog->title }}</a>
                        <p class="text-gray-700 mt-2">{!! Str::limit($blog->content, 100) !!}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-indigo-500 mt-4 inline-block">Read
                            More</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $blogs->links('pagination::tailwind') }}
        </div>

    </div>
</body>

</html>

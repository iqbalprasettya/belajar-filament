<!-- resources/views/tags/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Tagged with {{ $tag }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container mx-auto mt-10 px-4">
        <div class="text-center">
            <h1 class="text-xl font-bold lg:mx-32 lg:text-3xl mb-8">Posts Tagged with "{{ $tag }}"</h1>
        </div>

        @if ($blogs->isEmpty())
            <p class="text-center text-slate-500 mt-5">No posts found for this tag.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($blogs as $blog)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($blog->banner_image) }}" class="w-full h-48 object-cover"
                            alt="{{ $blog->title }}">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold">{{ $blog->title }}</h2>
                            <p class="text-gray-700 mt-2">{!! Str::limit($blog->content, 100) !!}</p>
                            <a href="{{ route('blog.show', $blog->slug) }}"
                                class="text-indigo-500 mt-4 inline-block">Read
                                More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6">
            {{ $blogs->links('pagination::tailwind') }}
        </div>

        <a href="{{ route('home') }}"
            class="text-sm items-center py-2 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700">
            <i class="fa-solid fa-chevron-left"></i> Back to Blog List
        </a>
    </div>
</body>

</html>

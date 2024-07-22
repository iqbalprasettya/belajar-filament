<!-- resources/views/blogs/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .sticky-sidebar {
            position: -webkit-sticky;
            /* Safari */
            position: sticky;
            top: 20px;
            /* Adjust this value based on your layout */
            max-height: calc(100vh - 20px);
            /* Adjust height based on layout and top margin */
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container mx-auto mt-10 px-4">
        <div class="text-center">
            <p class="font-medium text-base">Published <span
                    class="font-normal text-slate-500">{{ $blog->published_date->format('M d, Y') }}</span></p>
            <h1 class="text-xl font-bold lg:mx-32 lg:text-3xl">{{ $blog->title }}</h1>

        </div>
        <div class="border-y-2 my-5 py-3">
            {{-- button social media --}}
            <div class="flex flex-wrap justify-between mt-2 lg:mx-32">
                <p class="text-slate-500 mt-2">By <span class="font-semibold">{{ $blog->author }}</span> </p>
                <div class="social flex flex-wrap gap-2 my-3 lg:my-0">
                    <a href="" target="_blank"
                        class="text-sm items-center py-2 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700"><i
                            class="fa-brands fa-instagram"></i> Instagram</a>
                    <a href="" target="_blank"
                        class="text-sm items-center py-2 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700"><i
                            class="fa-brands fa-x-twitter"></i> Tweet</a>
                    <a href="" target="_blank"
                        class="text-sm items-center py-2 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700"><i
                            class="fa-solid fa-link"></i> Copy link</a>
                </div>
            </div>
        </div>

        {{-- content and mini menu in right --}}
        <div class="flex flex-wrap justify-between lg:mx-24">
            <div class="w-full lg:w-3/5 prose">
                {!! $blog->content !!}

                <a href="{{ route('home') }}"
                    class="text-sm items-center py-2 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700"><i
                        class="fa-solid fa-chevron-left"></i> Back to Blog List</a>

            </div>
            <div class="sticky-sidebar w-full mt-6 lg:w-1/3 lg:mt-0">
                {{-- related --}}
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold">Related Posts</h3>
                        @foreach ($relatedPosts as $post)
                            <div class="border-b pb-2 mb-2 flex flex-warp items-center gap-3">
                                <div class="image-post w-1/4">
                                    <img src="{{ Storage::url($post->banner_image) }}" class="w-28 h-auto mt-4 mb-4"
                                        alt="{{ $post->title }}">
                                </div>
                                <div class="body-post w-3/4">
                                    {{-- <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-500">
                                        {{ $post->title }}
                                    </a> substring --}}
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="text-indgo-500">{{ Str::limit($post->title, 30) }}</a>
                                    <p class="text-slate-500 text-sm">
                                        {{ $post->published_date->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Tags --}}
                <div class="flex flex-col gap-2 mt-5">
                    <h3 class="text-lg font-bold">Tags</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($blog->tags as $tag)
                            <a href="{{ route('tag.show', $tag) }}"
                                class="text-sm items-center py-1 px-4 rounded-md border-2 text-slate-500 hover:border-slate-300 hover:text-slate-700">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

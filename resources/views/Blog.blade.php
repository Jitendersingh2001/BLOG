<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phoenix Blog</title>
    <!-- CSS LINK -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <!-- TOAST CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- FLOWBITE -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="bg-white">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div>
                <a href="#" class="flex items-center">
                    <img src="/assets/img/logo.jpg" class="h-8 mr-3" alt="My blog Logo">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap">PHOENIX BLOGS</span>
                </a>
            </div>

            <div>
                @if (Route::has('login'))
                @auth
                <div class="id" data-user-id="{{ Auth::user()->id }}" data-blog-id="{{ $blog->id }}">

                </div>
                <div class="flex gap-1">
                    <div class="px-1 py-3">
                        <p class="text-sm text-gray-900  User-name">

                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <div>
                                <button type="button" class="flex text-sm rounded-full" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="w-10 h-10 rounded-full user-profile-pic" src="/assets/img/user.png" alt="user photo" />
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow text-black" id="dropdown-user">
                                <ul class="py-1" role="none">

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-3xl text-sm px-4 py-2 text-center me-2 mb-2  ">Log In</a>
                <a href="{{ route('register') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-3xl text-sm px-4 py-2 text-center me-2 mb-2  ">Register</a>
                @endauth

                @endif
            </div>
        </div>
    </nav>

    <!-- Category and date -->
    <div class="w-full py-1 border rounded border-gray-300 bg-gray-100 ">

        <div class="w-full container flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">
            <div class="flex justify-between items-center w-full">
                <div>
                    <p class="text-xs text-blue-600">
                        {{$blog->category}}
                    </p>
                </div>
                <div>
                    <p class="text-3xl text-gray-600">
                        {{$blog->title}}
                    </p>
                </div>
                <div>
                    <p class="text-xs flex gap-3 items-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                        </svg>
                        <?php

                        $formattedDate = (new DateTime($blog->created_at))->format('d-m-Y');
                        echo $formattedDate;
                        ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <!-- Blog Image -->
    <div class="relative z-0 mx-auto aspect-video max-w-screen-lg overflow-hidden lg:rounded-lg mb-4 !mt-5">
        <img alt="Thumbnail" loading="eager" decoding="async" data-nimg="fill" class="object-cover" sizes="100vw" srcset="{{$blog->BlogImage}}">
    </div>
    <!-- Blog Description -->
    <div class="container mx-auto xl:px-5 max-w-screen-lg py-5 lg:py-8">
        <article class="text-justify">
            <div class="prose mx-auto my-3 dark:prose-invert prose-a:text-blue-600 blog-description" style="max-width: 100%;">
                {{$blog->description}}
            </div>
        </article>
    </div>

    <!-- Comment Section -->
    <section class="bg-white py-8 lg:py-16 antialiased">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Post Comment</h2>
            </div>
            @if (Route::has('login'))
            @auth
            <form class="mb-6">
                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="6" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none" placeholder="Write a comment..." required></textarea>
                </div>
                <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 bg-blue-700 hover:bg-blue-900 Post-Comment-Btn">
                    Post comment
                </button>
            </form>
            @else
            <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200">
                <label for="comment" class="sr-only">Your comment</label>
                <textarea id="comment" rows="6" class="px-0 w-full cursor-not-allowed text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none" placeholder="Write a comment..." disabled></textarea>
            </div>
            <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 focus:outline-none">Log In</a>

            @endauth
            @endif
            <div class="Show-comments mt-4">
                <article class="p-6 text-base bg-white rounded-lg">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 font-semibold"><img class="mr-2 w-6 h-6 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Michael Gough">Michael Gough</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="February 8th, 2022">Feb. 8, 2022</time></p>
                        </div>
                    </footer>
                    <p class="text-gray-500">Very straight-to-point article. Really worth time reading. Thank you! But tools are just the
                        instruments for the UX designers. The knowledge of the design tools is as important as the
                        creation of the design strategy.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- JQUERY CDN LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- TOAST JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- FLOWBITE SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    <!-- JAVASCRIPT/JQUERY LINK -->

    <script src="{{ asset('assets/js/BlogScript.js') }}"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phoenix Blog Admin Panel</title>
    <!-- CSS LINK -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <!-- TOAST CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- FLOWBITE -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- component -->
    <div class="flex items-center justify-center h-screen">
        <!-- REGISTER Container -->
        <div class=" flex-col border border-gray-300 bg-white px-6 py-4 shadow-md rounded-[4px] ">
            <div class="mb-2 flex justify-center">
                <img class="w-10" src="assets/img/logo.jpg" alt="Logo" />
            </div>
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold ">
                    Register To Phoenix Blogs
                </h2>
            </div>
            <div class="flex flex-col space-y-4">
                <!-- method="POST" action="{{ route('login') }}" -->
                <form id="registerForm">
                    @csrf
                    <!-- Modify the input elements in your HTML file -->
                    <div>
                        <label for="UserName" class="block text-sm mb-2 font-medium text-gray-900">Name</label>
                        <input type="text" id="UserName" name="name" class="w-full rounded-[4px] border px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Enter Name">
                    </div>
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label for="UserEmail" class="block text-sm mb-2 font-medium text-gray-900">Email</label>
                            <input type="email" id="UserEmail" name="email" class="w-full rounded-[4px] border px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Enter Email">
                        </div>
                        <div class="w-1/2">
                            <label for="UserPhoneNo" class="block text-sm font-medium mb-2 text-gray-900">Phone No</label>
                            <input type="number" id="UserPhoneNo" name="phone_no" class="w-full rounded-[4px] border px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Enter Phone Number" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0, 10);">
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label for="UserPassword" class="block text-sm font-medium mb-2 text-gray-900">Password</label>
                            <input type="password" id="UserPassword" name="password" class="w-full rounded-[4px] border px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Enter Password" maxlength="15">
                        </div>
                        <div class="w-1/2">
                            <label for="ConfirmPassword" class="block text-sm font-medium mb-2 text-gray-900">Confirm Password</label>
                            <input type="password" id="ConfirmPassword" class="w-full rounded-[4px] border px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Enter Password" maxlength="15">
                        </div>
                    </div>
                    <div>
                        <label for="UserImage" class="block text-sm font-medium text-gray-900 mb-2">Upload Profile Pic</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="Image" id="UserImage" type="file">
                    </div>
                    <button class="mt-5 w-full border p-2 bg-blue-600 text-white rounded-[4px] hover:bg-blue-800 transform scale-105 duration-300 register-btn">Register</button>
                </form>
            </div>
            <div class="mt-5 flex justify-end text-sm text-gray-600">
                <a href="{{ route('login') }}">login</a>
            </div>
        </div>
    </div>
    <!-- JQUERY CDN LINK -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- TOAST JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- FLOWBITE SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
    <!-- JAVASCRIPT/JQUERY LINK -->
    <script src="{{ asset('assets/js/AuthScript.js') }}"></script>
</body>

</html>
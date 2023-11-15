<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phoenix Blog Login</title>
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
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- component -->
    <div class="flex items-center justify-center h-screen">
        <!-- Login Container -->
        <div class="w-96 flex-col border border-gray-300 bg-white px-6 pb-20 pt-14 shadow-md rounded-[4px] ">
            <div class="mb-5 flex justify-center">
                <img class="w-24" src="assets/img/logo.jpg" alt="Logo" />
            </div>
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold ">
                    Login In To Your Account
                </h2>
            </div>
            <div class="flex flex-col text-sm rounded-md">
                <!-- method="POST" action="{{ route('login') }}" -->
                <form id="LoginFom">

                    <input class="mb-5 w-full rounded-[4px] border p-3 hover:outline-none focus:outline-none hover:border-yellow-500 " id="login-email" type="email" name="email" placeholder="Enter Your Email id" />

                    <input class="border rounded-[4px] p-3 w-full hover:outline-none focus:outline-none hover:border-yellow-500" type="password" name="password" id="login-password" placeholder="Enter Password" />

                    <button class="mt-5 w-full border p-2  bg-blue-600 text-white rounded-[4px] hover:bg-blue-800 scale-105 duration-300 login-btn" type="submit">Sign in</button>
                </form>
            </div>
            <div class="mt-5 flex justify-end text-sm  text-gray-600">
                <!-- <a href="{{ route('password.request') }}">Forgot password?</a> -->
                <a href="{{ route('register') }}">Register</a>
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
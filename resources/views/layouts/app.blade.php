<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Monitoring Student Performance</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    </head>

    <body class="bg-pink-100">
        <nav class=" bg-white w-full w-screen flex relative justify-between items-center mx-auto px-8 h-20  bg-gray-900 text-white">
        <div class="inline-flex">
            <a class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full" href="{{  route('/home')  }}">
                <div class="flex items-center relative cursor-pointer whitespace-nowrap">Home</div>
            </a>
            @hasRole(['Admin', 'Lecturer'])
                <a id="My-Classes" class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full" href="{{  route('classes')  }}">
                    <div class="flex items-center relative cursor-pointer whitespace-nowrap">My Classes</div>
                </a>
            @endhasRole
            @hasRole(['Admin', 'Advisor'])
                <a id="Advising-Students" class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full" href="{{  route('students')  }}">
                    <div class="flex items-center relative cursor-pointer whitespace-nowrap">Advising Students</div>
                </a>
            @endhasRole
        </div>

        <div class="flex-initial">
        <div class="flex justify-end items-center relative">
        @guest
            <div class="flex mr-4 items-center">
                <a id="Login" class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full" href="{{  route('login')  }}">
                    <div class="flex items-center relative cursor-pointer whitespace-nowrap">Login</div>
                </a>
                <a id="Register" class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full" href="{{  route('register')  }}">
                    <div class="flex items-center relative cursor-pointer whitespace-nowrap">Register</div>
                </a>
            </div>
        @endguest
            @auth
            <div class="flex mr-4 items-center ml-2">
                <div x-data="{ dropdownOpen: false }" class="relative text-white hover:text-black">
                    <button @click="dropdownOpen = !dropdownOpen" class="inline-block py-2 px-3 hover:bg-blue-400 rounded-full">
                    <div class="flex items-center relative cursor-pointer whitespace-nowrap">
                                {{Auth::user()->fullname}}
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                    </button>

                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                    <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20">
                    @hasRole(['Admin', 'Lecturer', 'Advisor'])
                        <a href="{{  route('admin')  }}" id="Admin-Page" class="block px-4 py-2 text-sm text-white border-b bg-gray-500 hover:bg-blue-400 hover:text-black">Admin Page</a>
                    @endhasRole
                    @hasRole(['Admin', 'Lecturer'])
                        <a href="{{  route('classes')  }}" class="block px-4 py-2 text-sm text-white border-b bg-gray-500 hover:bg-blue-400 hover:text-black">My Classes</a>
                    @endhasRole
                    @hasRole(['Admin', 'Advisor'])
                        <a href="{{  route('students')  }}" class="block px-4 py-2 text-sm text-white border-b bg-gray-500 hover:bg-blue-400 hover:text-black">Advising Students</a>
                    @endhasRole
                    </div>
                </div>
            </div>
            <div class="flex mr-4 items-center ml-2">
                    <form action="{{ route('logout') }}" method="post" class="inline-block py-2 px-3 hover:bg-blue-400 hover:text-black rounded-full">
                        @csrf
                        <div class="flex items-center relative cursor-pointer whitespace-nowrap">
                            <button name="Logout" type="submit">Logout</button>
                        </div>
                    </form>
                </div>
            @endauth
            </div>
        </nav>
        <div class="mt-6">
            @yield('content')
        </div>
    </body>
</html>
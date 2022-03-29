<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Monitoring Student Performance - Administration</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    </head>

    <body class="flex bg-pink-100 rounded-xl m-3 shadow-xl">
    <aside class="flex px-16 space-y-16 overflow-hidden m-3 pb-4 flex-col items-center justify-center rounded-tl-xl rounded-bl-xl bg-gray-900 shadow-lg">
        <div class="flex items-center justify-center p-4 shadow-lg">
        <h1 class="text-white font-bold mr-2 cursor-pointer">Admin Nav</h1>
        </div>
        <ul>
        @hasRole(['Admin'])
            <form action="{{  route('accounts')  }}" method="get">
                <li class="flex space-x-2 mt-4 px-6 py-4 text-white hover:bg-white hover:text-blue-800 font-bold hover:rounded-br-3xl transition duration-100 cursor-pointer">
                    <button type="submit">Users</button>
                </li>   
            </form>
        @endhasRole
        @hasRole(['Admin', 'Lecturer'])
            <form action="{{  route('admin_classes')  }}" method="get">
                <li class="flex space-x-2 mt-4 px-6 py-4 text-white hover:bg-white hover:text-blue-800 font-bold hover:rounded-br-3xl transition duration-100 cursor-pointer">  
                    <button type="submit">Classes</button>
                </li>
            </form>
        @endhasRole
        @hasRole(['Admin', 'Advisor'])
            <form action="{{  route('circumstances')  }}" method="get">
                <li class="flex space-x-2 mt-4 px-6 py-4 text-white hover:bg-white hover:text-blue-800 font-bold hover:rounded-br-3xl transition duration-100 cursor-pointer">  
                    <button type="submit">Circumstances</button>
                </li>
            </form>
        @endhasRole
        <form action="{{ route('homepage') }}" method="get">
            <li class="flex space-x-2 mt-4 px-6 py-4 text-white hover:bg-white hover:text-blue-800 font-bold hover:rounded-br-3xl transition duration-100 cursor-pointer">
                <button type="submit">Return to App</button>
            </li>
        </form>
        </ul>
    </aside>
    <main class="flex-col bg-gray-300 w-full ml-4 pr-6">
        <div class="mt-6 mb-12">
            @yield('content')
        </div>
    </main>
    </body>
</html>
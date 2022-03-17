@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Login</b></h2>
                <form action="{{ route('login_confirm') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input type="text" name="email" id="email" placeholder="Your email" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('email') border-red-500 @enderror rounded-lg" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" placeholder="Choose a password" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('password') border-red-500 @enderror rounded-lg" value="">

                        @error('password')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4 justify-items-stretch auto-rows-fr">
                        <div class="flex justify-center items-center">
                            <button type="submit" name="Login" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Login</button>
                        </div>
                </form>
                <form action="{{ route('forgot_password') }}" method="post">
                    <div class="flex justify-center items-center">
                            <button type="submit" name="Forgot Password" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Forgot Password</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
@endsection
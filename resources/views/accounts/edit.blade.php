@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Login</b></h2>
                <!--<form action="{{ route('login_confirm') }}" method="post">--><form>
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="sr-only">Username</label>
                        <input type="text" name="username" id="username" placeholder="username" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('username') border-red-500 @enderror rounded-lg" value="{{ old('username') }}">
                        @error('email')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="fullname" class="sr-only">Full Name</label>
                        <input type="text" name="fullname" id="fullname" placeholder="full name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('fullname') border-red-500 @enderror rounded-lg" value="{{ old('fullname') }}">
                        @error('email')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input type="text" name="email" id="email" placeholder="email" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('email') border-red-500 @enderror rounded-lg" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" placeholder="password" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('password') border-red-500 @enderror rounded-lg" value="">

                        @error('password')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4 justify-items-stretch auto-rows-fr">
                        <div class="flex justify-center items-center">
                            <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Update Details <i class="fas fa-pencil-alt"></i></button>
                        </div>
                </form>
        </div>
    </div>
@endsection
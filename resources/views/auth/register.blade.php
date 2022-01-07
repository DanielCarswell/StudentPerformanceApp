@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Register</b></h2>
                <form action="{{ route('register_confirm') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="firstname" class="sr-only">First Name</label>
                        <input type="text" name="firstname" id="firstname" placeholder="Your First Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('firstname') border-red-500 @enderror rounded-lg" value="{{ old('firstname') }}">
                        @error('firstname')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="lastname" class="sr-only">Last Name</label>
                        <input type="text" name="lastname" id="lastname" placeholder="Your Last Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('lastname') border-red-500 @enderror rounded-lg" value="{{ old('lastname') }}">
                        @error('lastname')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="sr-only">Email</label>
                        <input type="text" name="email" id="email" placeholder="Your Email" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('email') border-red-500 @enderror rounded-lg" value="{{ old('email') }}">
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
                    <div class="mb-6">
                        <label for="confirmpassword" class="sr-only">Confirm Password</label>
                        <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm password" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('confirmpassword') border-red-500 @enderror rounded-lg" value="">

                        @error('confirmpassword')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Complete Registeration</button>
                    </div>
                </form>
        </div>
    </div>
@endsection
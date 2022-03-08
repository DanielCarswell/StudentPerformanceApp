@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Edit Account</b></h2>
            <form action="{{ route('account.update') }}" method="post">
                @csrf
                <input name="user_id" value="{{ $account->id }}" type="hidden">
                <div class="mb-4">
                    <label for="email">Email Address: </label>
                    <input type="text" name="email" id="email" placeholder="Enter Email" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('email') border-red-500 @enderror rounded-lg" value="{{ $account->email }}">
                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="firstname">First Name: </label>
                    <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('firstname') border-red-500 @enderror rounded-lg" value="{{ $account->firstname }}">
                    @error('firstname')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="lastname">Last Name: </label>
                    <input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('lastname') border-red-500 @enderror rounded-lg" value="{{ $account->lastname }}">
                    @error('lastname')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Edit Account Details</button>
                </div>
            </form>
            <form action="{{ route('accounts')  }}" method="get">
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
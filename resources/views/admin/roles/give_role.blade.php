@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Add Role for User {{  $user->fullname  }}</b></h2>
            <form action="{{ route('give_user_role') }}" method="post">
                @csrf
                <input name="user_id" value="{{ $user->id }}" type="hidden">
                <div class="mb-4 dropdown box-content inline-block relative text-black flex justify-center">
                    <label for="role" class="sr-only">Add Role: </label>
                    <select name="role" id="role" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('role') border-red-500 @enderror rounded-lg" value="{{ old('role') }}">
                        <option value="Select Role">Select Role</option>
                        @if($roles->count())
                            @foreach($roles as $role)
                                <option value="{{  $role->name  }}">{{  $role->name  }}</option>
                            @endforeach
                        @else
                            <option value="None Available">None Available</option>
                        @endif
                    </select>
                    @error('role')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add User Role</button>
                </div>
            </form>
            <a href="{{ route('user_roles', $user->id)  }}">
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </a>
        </div>
    </div>
@endsection
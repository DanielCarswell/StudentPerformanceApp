@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Edit Assignment</b></h2>
            <form action="{{ route('modify_role') }}" method="post">
                @csrf
                <input name="role_id" value="{{ $role->id }}" type="hidden">
                <div class="mb-4">
                    <label for="rolename">Role name: </label>
                    <input type="text" name="rolename" id="rolename" placeholder="Enter Role Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('rolename') border-red-500 @enderror rounded-lg" value="{{ $role->name }}">
                    @error('rolename')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Edit Role</button>
                </div>
            </form>
            <form action="{{ route('role_index')  }}" method="get">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Create New Class</b></h2>
            <form action="{{ route('class.create') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="classname" class="sr-only">Class Name</label>
                    <input type="text" name="classname" id="classname" placeholder="Enter Class Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classname') border-red-500 @enderror rounded-lg" value="{{ old('classname') }}">
                    @error('classname')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Class</button>
                </div>
            </form>
            <a href="{{ route('admin_classes')  }}">
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#57c4ad;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </a>
        </div>
    </div>
@endsection
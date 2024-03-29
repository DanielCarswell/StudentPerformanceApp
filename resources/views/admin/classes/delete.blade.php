@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 mb-4 flex justify-center"><b>Delete Class</b></h2>
            <form action="{{ route('destroy_class', $class->id) }}" method="post">
                @csrf
                @method('delete')
                <input name="class" value="{{ $class }}" type="hidden">
                <div class="mb-4 text-xl">
                    <label for="classname">Class Name: {{  $class->name  }}</label>
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Delete</button>
                </div>
            </form>
            <a href="{{ route('admin_classes')  }}">
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#57c4ad;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Cancel
                    </button>
                </span>
            </a>
        </div>
    </div>
@endsection
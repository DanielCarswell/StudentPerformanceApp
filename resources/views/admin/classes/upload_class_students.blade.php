@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Upload Students</b></h2>
            <form action="{{ route('file.upload.students') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input name="class_id" value="{{ $class_id }}" type="hidden">
                <input type="file" name="upload" />
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Students To Class</button>
                </div>
            </form>
            <form action="" method="post">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#57c4ad;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
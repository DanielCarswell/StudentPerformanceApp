@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Upload Student(s) Details</b></h2>
            <form action="{{ route('file.upload.student_accounts') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="upload" />
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Upload Students
                    </button>
                </div>
            </form>
            <form action="{{  route('accounts')  }}" method="get">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
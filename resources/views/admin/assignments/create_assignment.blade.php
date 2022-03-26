@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Create New Assignment</b></h2>
            <form action="{{ route('add_assignment') }}" method="post">
                @csrf
                <input name="class_id" value="{{ $class_id }}" type="hidden">
                <div class="mb-4">
                    <label for="assignmentname" class="sr-only">Assignment name</label>
                    <input type="text" name="assignmentname" id="assignmentname" placeholder="Enter Assignment Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('assignmentname') border-red-500 @enderror rounded-lg" value="{{ old('assignmentname') }}">
                    @error('assignmentname')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="classworth" class="sr-only">Class Worth(% of Class Total)</label>
                    <input type="text" name="classworth" id="classworth" placeholder="Enter Class Worth(%)" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classworth') border-red-500 @enderror rounded-lg" value="{{ old('classworth') }}">
                    @error('classworth')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label>Is this an Exam?</label>
                    <input type="checkbox" name="isexam" id="isexam">
                    @error('isexam')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Assignment</button>
                </div>
            </form>
            <form action="{{ route('class_assignments', $class_id)  }}" method="post">
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
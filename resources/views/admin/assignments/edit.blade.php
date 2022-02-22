@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Edit Assignment</b></h2>
            <form action="{{ route('modify_assignment') }}" method="post">
                @csrf
                <input name="class_id" value="{{ $class_id }}" type="hidden">
                <input name="assignment_id" value="{{ $assignment->id }}" type="hidden">
                <div class="mb-4">
                    <label for="assignmentname">Assignment name: </label>
                    <input type="text" name="assignmentname" id="assignmentname" placeholder="Enter Assignment Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('assignmentname') border-red-500 @enderror rounded-lg" value="{{ $assignment->name }}">
                    @error('assignmentname')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="classworth">Class Worth(% of Class Total): </label>
                    <input type="text" name="classworth" id="classworth" placeholder="Enter Class Worth(%)" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classworth') border-red-500 @enderror rounded-lg" value="{{ $assignment->class_worth }}">
                    @error('classworth')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label>Is this an Exam?</label>
                    @if($assignment->is_exam == TRUE)
                        <input type="checkbox" name="isexam" id="isexam" checked>
                    @else
                        <input type="checkbox" name="isexam" id="isexam">
                    @endif
                    @error('isexam')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Edit Assignment</button>
                </div>
            </form>
            <form action="{{ route('class_assignments', $class_id)  }}" method="post">
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
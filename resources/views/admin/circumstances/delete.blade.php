@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 mb-4 flex justify-center"><b>Delete Assignment</b></h2>
                <div class="mb-4 text-xl">
                    <label for="assignmentname">Assignment Name: {{  $assignment->name  }}</label>
                </div>
                <div class="mb-4 text-xl">
                    <label for="classworth">Class Worth: {{  $assignment->class_worth  }}%</label>
                </div>
                <div class="mb-6  text-xl">
                    <label for="isexam">Is this an Exam? {{ $assignment->exam }}</label>
                </div>
                <form action="{{route('circumstance.destroy', $circumstance)}}" method="post">
                @csrf
                @method('delete')
                    <div class="flex justify-center items-center">
                        <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Delete</button>
                    </div>
                </form>
            <form action="{{ route('class_assignments', $class_id)  }}" method="post">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Cancel
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
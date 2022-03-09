@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Add Circumstance for Student {{  $student->fullname  }}</b></h2>
            <form action="{{ route('student.circumstance.update') }}" method="post">
                @csrf
                <input name="student_id" value="{{ $student->id }}" type="hidden">
                <div class="mb-4 dropdown box-content inline-block relative text-black flex justify-center">
                    <label for="circumstance" class="sr-only">Add Circumstance: </label>
                    
                    <select name="circumstance" id="circumstance" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('circumstance') border-red-500 @enderror rounded-lg" value="{{ old('circumstance') }}">
                        @error('circumstance')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        <option value="Select Circumstance">Select Circumstance</option>
                        @if($circumstances->count())
                            @foreach($circumstances as $circumstance)
                                <option value="{{  $circumstance->name  }}">{{  $circumstance->name  }}</option>
                            @endforeach
                        @else
                            <option value="None Available">None Available</option>
                        @endif
                    </select>
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Student Circumstance</button>
                </div>
            </form>
            <a href="{{ route('student.circumstances', $student)  }}">
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </a>
        </div>
    </div>
@endsection
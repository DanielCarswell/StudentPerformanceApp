@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Edit Student Note</b></h2>
                <form action="{{ route('student.note.modify') }}" method="post">
                <input name="student_id" value="{{ $student->id }}" type="hidden">
                <input name="advisor_id" value="{{ $advisor->id }}" type="hidden">
                <input name="old_topic" value="{{ $topic }}" type="hidden">
                <input name="old_note" value="{{ $note }}" type="hidden">
                    @csrf
                    <div class="mb-4">
                        <label for="topic" class="sr-only">Topic</label>
                        <input type="text" name="topic" id="topic" placeholder="Enter Topic" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('topic') border-red-500 @enderror rounded-lg" value="{{ $topic }}">
                        @error('topic')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="note" class="sr-only">Note</label>
                        <input type="text" name="note" id="note" placeholder="Enter Note" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('note') border-red-500 @enderror rounded-lg" value="{{ $note }}">
                        @error('note')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-3 rounded font-bold w-full">Edit Note</button>
                    </div>
                </form>
                <form action="{{  route('student.notes', $student) }}" method="get">
                    @csrf
                    <button name="Go Back" type="submit" class="bg-purple-500 text-white px-4 py-3 mt-2 rounded font-bold w-full">
                        Go Back
                    </button>
                </form>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Student Note</b></h2>
                <form action="{{ route('student.note.update') }}" method="post">
                <input name="student_id" value="{{ $student->id }}" type="hidden">
                <input name="advisor_id" value="{{ $advisor->id }}" type="hidden">
                    @csrf
                    <div class="mb-4">
                        <label for="topic" class="sr-only">Topic</label>
                        <input type="text" name="topic" id="topic" placeholder="Enter Topic" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('topic') border-red-500 @enderror rounded-lg" value="{{ old('topic') }}">
                        @error('topic')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="note" class="sr-only">Note</label>
                        <input type="text" name="note" id="note" placeholder="Enter Note" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('note') border-red-500 @enderror rounded-lg" value="{{ old('note') }}">
                        @error('note')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Note</button>
                    </div>
                </form>
        </div>
    </div>
@endsection
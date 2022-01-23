@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Create New Class</b></h2>
                <form action="{{ route('create_class') }}" method="post">
                    @csrf
                    <div class="mb-4 dropdown box-content inline-block relative text-black flex justify-center">
                        <label for="coursename" class="sr-only">Which course is this Class: </label>
                        
                        <select name="course" id="course" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classcode') border-red-500 @enderror rounded-lg" value="{{ old('classcode') }}">
                            @error('course')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                            <option value="Select Course">Select Course</option>
                            <option value="rigatoni">Computing Science</option>
                            <option value="dave">Hairdressing</option>
                            <option value="pumpernickel">Software Engineering</option>
                            <option value="reeses">Robotics</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="classcode" class="sr-only">Class Code</label>
                        <input type="text" name="classcode" id="classcode" placeholder="Enter Class Code" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classcode') border-red-500 @enderror rounded-lg" value="{{ old('classcode') }}">
                        @error('classcode')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="classname" class="sr-only">Class Name</label>
                        <input type="text" name="classname" id="classname" placeholder="Enter Class Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classname') border-red-500 @enderror rounded-lg" value="{{ old('classname') }}">
                        @error('classname')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="classyear" class="sr-only">Class Year</label>
                        <input type="text" name="classyear" id="classyear" placeholder="Enter Year of Study" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classyear') border-red-500 @enderror rounded-lg" value="{{ old('classyear') }}">
                        @error('classyear')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="classcredits" class="sr-only">Class Credits</label>
                        <input type="classcredits" name="classcredits" id="classcredits" placeholder="Enter Credits for Class" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('classcredits') border-red-500 @enderror rounded-lg" value="{{  old('classcredits')  }}">
                        @error('classcredits')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Class</button>
                    </div>
                </form>
        </div>
    </div>
@endsection
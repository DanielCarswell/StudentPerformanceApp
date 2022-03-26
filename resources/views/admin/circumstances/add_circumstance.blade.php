@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Create New Circumstance</b></h2>
            <form action="{{ route('circumstance.create') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="name" class="sr-only">Circumstance name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Circumstance Name" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('name') border-red-500 @enderror rounded-lg" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="information" class="sr-only">Circumstance Information</label>
                    <input type="text" name="information" id="information" placeholder="Enter Circumstance Information" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('information') border-red-500 @enderror rounded-lg" value="{{ old('information') }}">
                    @error('information')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Circumstance</button>
                </div>
            </form>
            <form action="{{ route('circumstances')  }}" method="get">
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
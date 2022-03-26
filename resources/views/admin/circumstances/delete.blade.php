@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 mb-4 flex justify-center"><b>Delete Circumstance</b></h2>
                <div class="mb-4 text-xl">
                    <label for="assignmentname">Name: {{  $circumstance->name  }}</label>
                </div>
                <div class="mb-4 text-xl">
                    <label for="classworth">Information: {{  $circumstance->information  }}</label>
                </div>
                <form action="{{route('circumstance.destroy', $circumstance)}}" method="post">
                @csrf
                @method('delete')
                    <div class="flex justify-center items-center">
                        <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Delete</button>
                    </div>
                </form>
            <form action="{{ route('circumstances')  }}" method="get">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#57c4ad;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Cancel
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
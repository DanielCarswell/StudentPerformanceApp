@extends('layouts.app')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $student->fullname  }} Circumstances</p>
    <div class="px-16 py-2 flex justify-center">
        <a href="{{ route('student.circumstance.add', $student)  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Circumstance
                </button>
            </span>
        </a>
        <form action="{{  route('students') }}" method="get">
          @csrf
          <button name="Go Back" type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
              Go Back
          </button>
        </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Information</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($circumstances->count())
          @foreach($circumstances as $circumstance)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $circumstance->name  }}</span>
                </td>
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $circumstance->information  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                    <form action="{{  route('student.circumstance.remove', [$student->id, $circumstance->id])  }}" method="post">
                        @csrf
                        @method('delete')
                        <input name="student_id" value="{{ $student->id }}" type="hidden">
                        <input name="circumstance_id" value="{{ $circumstance->circumstance_id }}" type="hidden">
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Remove Circumstance
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
          @endforeach
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
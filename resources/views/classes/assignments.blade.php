@extends('layouts.app')

@section('content')
    <div class="ml-12 mr-12">
    <h2 class="text-2xl font-extrabold flex justify-center mb-6">{{$class->name}} Assignments</h2>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Assignment Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Average Mark</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($assignments->count())
          @foreach($assignments as $assignment)
            <tr class="bg-white border-4 border-gray-200 ">
              <td>
                  <span class="text-center ml-2 font-semibold flex justify-center">{{  $assignment->name  }}</span>
              </td>
              <td>
                  <span class="text-center ml-2 font-semibold flex justify-center">{{  $assignment->average  }}</span>
              </td>
              <td class="px-16 py-2">
                  <form action="{{ route('assignment_grades', [$assignment, $class])  }}" method="post">
                      @csrf
                      <span class="flex justify-center">
                          <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                          Add/Change Assignment Marks <i class="fas fa-plus"></i>
                          </button>
                      </span>
                  </form>
              </td>
            </tr>
          @endforeach
          {{  $assignments->links()  }}
        @else
          <p>No students in class</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
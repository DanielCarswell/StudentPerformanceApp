@extends('layouts.app')

@section('content')
    <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">My Students</p>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Student Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Average Grade</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Student Link</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($students1->count())
          @foreach($students1 as $student)
            <x-student-links :student='$student' />
          @endforeach
          {{  $students1->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
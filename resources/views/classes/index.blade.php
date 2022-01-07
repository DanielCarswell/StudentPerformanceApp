@extends('layouts.app')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">My Classes</p>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Class Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Average Grade</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Class Link</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($classes1->count())
          @foreach($classes1 as $class)
            <x-class-links :class='$class' />
          @endforeach

          {{  $classes1->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
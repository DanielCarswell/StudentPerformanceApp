@extends('layouts.app')

@section('content')
    <div class="ml-12 mr-12">
    <h2 class="text-2xl font-extrabold flex justify-center mb-6">{{$class->name}} - {{$assignment->name}} Grades</h2>
    <div class="mb-6">
    <a href="{{ route('upload_assignment_marks')  }}">
      <span class="flex justify-center">
          <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
              <i class="fas fa-plus"></i>&nbsp;&nbsp;Upload Assignment Marks
          </button>
      </span>
    </a>
        <form action="{{  route('search_roles')  }}" method="post" role="search">
            @csrf
            <div class="input-group">
                <label class="text-xl">Search Roles: </label>
                <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search Roles">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Student Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Assignment Mark</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Update Mark</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($students->count())
          @foreach($students as $student)
            <tr class="bg-white border-4 border-gray-200 ">
              <td>
                  <span class="text-center ml-2 font-semibold flex justify-center">{{  $student->fullname  }}</span>
              </td>
            </tr>
          @endforeach
          {{  $students->links()  }}
        @else
          <p>No students in class</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
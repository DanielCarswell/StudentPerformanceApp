@extends('layouts.app')

@section('content')
    <div class="ml-12 mr-12">
    <h2 class="text-2xl font-extrabold flex justify-center mb-6">{{$class->name}} - {{$assignment->name}} Grades</h2>
    <div class="mb-6 flex justify-center">
    @hasRole(['Admin', 'Lecturer'])
      <form action="{{ route('upload_assignment_marks')  }}" method="get">
        <input name="class_id" value="{{$class->id}}" type="hidden">
        <input name="assignment_id" value="{{ $assignment->id }}" type="hidden">
            <button name="Upload Assignment Marks" type="submit" style="background-color:#57c4ad;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Upload Assignment Marks
            </button>
      </form>
      <form action="{{  route('class.assignments', $class) }}" method="post">
          @csrf
          <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
              Go Back
          </button>
      </form>
      @endhasRole
    </div>
    <div class=" flex justify-center">
      @error('percent')
          <div class="text-red-500 mt-2 text-xl">
              {{ $message }}
          </div>
      @enderror
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
              <td>
                  <span class="text-center ml-2 font-semibold flex justify-center">{{  $student->percent  }}%</span>
              </td>
              <td>
              @hasRole(['Admin', 'Lecturer'])
                <form action="{{  route('update_assignment_mark')  }}" method="post" role="search">
                  @csrf
                  <input name="class_id" value="{{$class->id}}" type="hidden">
                  <input name="assignment_id" value="{{ $assignment->id }}" type="hidden">
                  <input name="student_id" value="{{ $student->id }}" type="hidden">
                  <div class="input-group flex justify-center">
                      <label class="text-xl pt-4">Enter Mark: </label>
                      <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="percent" placeholder="Enter Mark Here">
                          <span>
                          <button type="submit" class="mt-2 bg-purple-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                              Enter Mark
                          </button>
                      </span>
                  </div>
                </form>
              @endhasRole
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
@extends('layouts.app')

@section('content')
    <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">Advising Students</p>
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
            <span class="text-gray-300">Average Attendance</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Student Link</span>
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
              @if($student->average_grade >= 50)
                  <td class="ml-128 mr-128">
                      <span style="background-color:#4dac26;" class="px-2 py-1 pt-2 pb-2 ml-3 mr-3 font-semibold leading-tight rounded-full flex justify-center">{{  $student->average_grade  }}%</span>
                  </td>
              @else
                  <td class="ml-128 mr-128">
                      <span class="px-2 py-1 pt-2 pb-2 ml-3 mr-3 font-semibold leading-tight bg-purple-300 rounded-full flex justify-center">{{  $student->average_grade  }}%</span>
                  </td>
              @endif
              @if($student->average_attendance >= 50)
                  <td class="ml-128 mr-128">
                      <span style="background-color:#4dac26;" class="px-2 py-1 pt-2 pb-2 ml-3 mr-3 font-semibold leading-tight rounded-full flex justify-center">{{  $student->average_attendance  }}%</span>
                  </td>
              @else
                  <td class="ml-128 mr-128">
                      <span class="px-2 py-1 pt-2 pb-2 ml-3 mr-3 font-semibold leading-tight bg-purple-300 rounded-full flex justify-center">{{  $student->average_attendance  }}%</span>
                  </td>
              @endif
              <td class="px-16 py-2 flex justify-center">
                <form action="{{ route('classes.student_records', $student)  }}" method="post">
                    @csrf
                    <span class="flex justify-center">
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                        View Students Records <i class="fas fa-plus"></i>
                        </button>
                    </span>
                </form>
                @hasRole(['Admin', 'Moderator', 'Lecturer', 'Advisor', 'Staff'])
                <form action="{{ route('student.circumstances', $student)  }}" method="post">
                    @csrf
                    <span class="flex justify-center">
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 border rounded-md hover:bg-white hover:text-black">
                        View Circumstances <i class="fas fa-plus"></i>
                        </button>
                    </span>
                </form>
                @endhasRole
                @hasRole(['Advisor'])
                <form action="{{ route('student.notes', $student)  }}" method="post">
                    @csrf
                    <span class="flex justify-center">
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 border rounded-md hover:bg-white hover:text-black">
                        View Advisor Notes <i class="fas fa-plus"></i>
                        </button>
                    </span>
                </form>
                @endhasRole
                <form action="{{ route('graph.student_details', $student)  }}" method="post">
                    @csrf
                    <span class="flex justify-center">
                        <button type="submit" class="bg-purple-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                            View Performance Graph <i class="fas fa-star"></i>
                        </button>
                    </span>
                </form>
              </td>
            </tr>
          @endforeach
          {{  $students->links()  }}
        @else
          <p>You are not assigned as Advisor for any Students</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
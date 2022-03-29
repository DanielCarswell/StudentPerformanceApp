@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $class->name  }} Students</p>
    <div class="px-16 py-2 flex justify-center">
    @hasRole(['Admin', 'Lecturer'])
      <form action="{{  route('class.students.add', $class)  }}" method="post" >
        @csrf
        <span class="flex justify-center">
            <button type="submit" style="background-color:#57c4ad;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Student
            </button>
        </span>
      </form>
      <form action="{{ route('upload_students')  }}" method="get">
        <input name="class_id" value="{{$class->id}}" type="hidden">
        <span class="flex justify-center">
            <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Upload Students - CSV File
            </button>
        </span>
      </form>
      <form action="{{ route('admin_classes')  }}" method="get">
        <span class="flex justify-center">
            <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                Go Back
            </button>
        </span>
      </form>
      @endhasRole
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Student Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Class Grade</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
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
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  number_format((float)$student->class_mark, 0, '.', '')  }}%</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                @hasRole(['Admin', 'Lecturer'])
                    <form action="{{  route('class.delete_student', [$class->id, $student->id])  }}" method="post">
                        @csrf
                        @method('delete')
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete from Class
                            </button>
                        </span>
                    </form>
                    @endhasRole
                </td>
            </tr>
          @endforeach

          {{  $students->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
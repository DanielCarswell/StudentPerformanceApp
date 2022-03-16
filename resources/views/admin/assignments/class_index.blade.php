@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $class->name  }} Assignments</p>
    <div class="px-16 py-2 flex justify-center">
    @hasRole(['Admin', 'Moderator', 'Lecturer'])
        <a href="{{ route('create_assignment', $class->id)  }}">
            <span class="flex justify-center">
                <button type="submit"  style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Assignment
                </button>
            </span>
        </a>
        @endhasRole
    </div>
    <div>
      <h2>(Please be careful that the total does not exceed 100% class worth)</h2>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Class Worth</span>
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
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $assignment->class_worth  }}%</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                @hasRole(['Admin', 'Moderator', 'Lecturer'])
                  <form action="{{ route('class.assignments', $class)  }}" method="post">
                      @csrf
                      <span class="flex justify-center">
                        <button type="submit"class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:border-indigo-500 hover:text-black">
                              <i class="fas fa-clipboard"></i>&nbsp;&nbsp;View Assignment
                          </button>
                      </span>
                  </form>
                  <form action="{{ route('edit_assignment', [$assignment->id, $class->id])  }}" method="post">
                      @csrf
                      <span class="flex justify-center">
                          <button type="submit" style="background-color:#f97316;" class="bg-orange-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit Assignment Details
                          </button>
                      </span>
                  </form>
                  <form action="{{ route('delete_assignment', [$class->id, $assignment->id])  }}" method="post">
                      @csrf
                      <span class="flex justify-center">
                          <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Assigment
                          </button>
                      </span>
                  </form>
                  @endhasRole
                </td>
            </tr>
          @endforeach

          {{  $assignments->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
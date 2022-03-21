@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">All Classes</p>
    <div class="px-16 py-2 flex justify-center">
    @hasRole(['Admin', 'Moderator', 'Lecturer'])
      <a href="{{ route('create_class')  }}">
          <span class="flex justify-center">
              <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Create Class
              </button>
          </span>
      </a>
      @endhasRole
      <a href="{{ route('admin_classes')  }}">
          <span class="flex justify-center">
              <button type="submit" style="background-color:#a6611a;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-circle-notch"></i>&nbsp;&nbsp;Reset Search
              </button>
          </span>
      </a>
    </div>
    <div class="mb-6">
    <form action="{{  route('search_classes')  }}" method="post" role="search">
      @csrf
      <div class="input-group">
        <label class="text-xl">Search Classes: </label>
          <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search classes">
            <span class="input-group-btn">
              <button type="submit" class="bg-purple-400 text-white px-8 py-4 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">Search Classes
              </button>
          </span>
      </div>
    </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Class Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($classes->count())
          @foreach($classes as $class)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $class->name  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                    <form action="{{ route('class.lecturers', $class->id)  }}" method="post">
                      @csrf
                      <span class="flex justify-center">
                          <button type="submit" class="bg-blue-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Manage Lecturers
                          </button>
                      </span>
                    </form>
                    <form action="{{ route('class.students', $class->id)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                              <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Manage Students
                            </button>
                        </span>
                    </form>
                    <form action="{{ route('class_assignments', $class->id)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" class="bg-blue-700 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                              <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;View Assignments
                            </button>
                        </span>
                    </form>
                    @hasRole(['Admin', 'Moderator', 'Lecturer'])
                    <form action="{{ route('class.edit', $class)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#f97316;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                              <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit Class Details
                            </button>
                        </span>
                    </form>
                    <form action="{{ route('delete_class', $class)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Class
                            </button>
                        </span>
                    </form>
                    @endhasRole
                </td>
            </tr>
          @endforeach
          {{  $classes->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
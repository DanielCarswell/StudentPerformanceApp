@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">All Classes</p>
    <div class="px-16 py-2 flex justify-center">
      <a href="{{ route('create_class')  }}">
          <span class="flex justify-center">
              <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Create Class
              </button>
          </span>
      </a>
      <a href="{{ route('admin_classes')  }}">
          <span class="flex justify-center">
              <button type="submit" style="background-color:#a6611a;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-circle-notch"></i>&nbsp;&nbsp;Reset Search
              </button>
          </span>
      </a>
    </div>
    <div class="mb-6">
    <form action="{{  route('class.search_students')  }}" method="post" role="search">
      @csrf
      <div class="input-group">
        <label class="text-xl">Search Classes: </label>
          <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search classes">
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
            <span class="text-gray-300">Course</span>
          </th>
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
                    <form action="" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Add Student
                            </button>
                        </span>
                    </form>
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
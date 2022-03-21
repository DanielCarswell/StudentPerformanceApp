@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">Add Lecturer</p>
    <div class="px-16 py-2 flex justify-center">
      <form action="{{ route('class.lecturers.add', $class->id)  }}" method='get'>
          <span class="flex justify-center">
              <button type="submit" style="background-color:#a6611a;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-circle-notch"></i>&nbsp;&nbsp;Reset Search
              </button>
          </span>
      </form>
      <form action="{{ route('class.lecturers', $class->id)  }}" method="any">
        <span class="flex justify-center">
            <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                Go Back
            </button>
        </span>
      </form>
    </div>
    <div class="mb-6">
    <form action="{{  route('search_class_lecturers')  }}" method="post" role="search">
      @csrf
      <input name="class_id" value="{{$class->id}}" type="hidden">
      <div class="input-group">
        <label class="text-xl">Search Lecturers: </label>
          <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search lecturers">
              <button type="submit" class="bg-purple-400 text-white px-8 py-4 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">Search Lecturers
              </button>
      </div>
    </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Lecturer Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($lecturers->count())
          @foreach($lecturers as $lecturer)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $lecturer->fullname  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                    <form action="{{  route('class.add_lecturer', [$class->id, $lecturer->id])  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Add Lecturer
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
          @endforeach

          {{  $lecturers->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
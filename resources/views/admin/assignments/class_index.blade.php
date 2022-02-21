@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $class->name  }} Assignments</p>
    <div class="px-16 py-2 flex justify-center">
        <a href="{{ route('create_assignment', $class->id)  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Assignment
                </button>
            </span>
        </a>
        <form action="{{  route('class_assignments', $class)  }}" method="post" >
            @csrf
            <span class="flex justify-center">
                <button type="submit" style="background-color:#a6611a;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-circle-notch"></i>&nbsp;&nbsp;Reset Search
                </button>
            </span>
        </form>
    </div>
    <div class="mb-6">
    <form action="{{  route('search_assignments')  }}" method="post" role="search">
        @csrf
        <div class="input-group">
            <input name="class_id" value="{{ $class->id }}" type="hidden">
            <label class="text-xl">Search Class Assignments: </label>
            <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search Assignments">
                <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
    </div>
    <div>
      <h2>(Please be careful that total does not exceed 100% class worth)</h2>
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
                    <form action="{{ route('classes.class_records', $class)  }}" method="post">
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
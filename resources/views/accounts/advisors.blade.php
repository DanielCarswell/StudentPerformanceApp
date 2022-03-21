@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $student->fullname  }}'s Advisors</p>
    <div class="px-16 py-2 flex justify-center">
    @hasRole(['Admin', 'Moderator', 'Advisor'])
      <form action="{{  route('student.advisors.add', $student)  }}" method="post" >
        @csrf
        <span class="flex justify-center">
            <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Advisor
            </button>
        </span>
      </form>
      <form action="{{ route('accounts')  }}" method="get">
        <span class="flex justify-center">
            <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
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
            <span class="text-gray-300">Advisor Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($advisors->count())
          @foreach($advisors as $advisor)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $advisor->fullname  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                @hasRole(['Admin', 'Moderator', 'Advisor'])
                    <form action="{{  route('student.delete_advisor', [$student->id, $advisor->id])  }}" method="post">
                        @csrf
                        @method('delete')
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Remove Student Advisor
                            </button>
                        </span>
                    </form>
                @endhasRole
                </td>
            </tr>
          @endforeach

          {{  $advisors->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
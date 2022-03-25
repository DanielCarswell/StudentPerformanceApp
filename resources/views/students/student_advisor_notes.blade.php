@extends('layouts.app')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $student->fullname  }} Student Advisor Notes</p>
    <div class="px-16 py-2 flex justify-center">
        <a href="{{ route('student.note.add', $student)  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Note
                </button>
            </span>
        </a>
        <form action="{{  route('students') }}" method="get">
          @csrf
          <button name="Go Back" type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
              Go Back
          </button>
        </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Topic</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Note</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($notes->count())
          @foreach($notes as $note)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $note->topic  }}</span>
                </td>
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $note->note  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                    <form action="{{  route('student.note.edit', [$student->id, $note->topic, $note->note])  }}" method="post">
                        @csrf
                        <input name="student_id" value="{{ $student->id }}" type="hidden">
                        <input name="advisor_id" value="{{ $advisor->id }}" type="hidden">
                        <input name="topic" value="{{ $note->topic }}" type="hidden">
                        <input name="note" value="{{ $note->note }}" type="hidden">
                        <span class="flex justify-center">
                            <button type="submit" class="bg-red-400 text-white px-4 py-2 border rounded-md hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Edit Note
                            </button>
                        </span>
                    </form>
                    <form action="{{  route('student.note.remove', [$student->id, $advisor->id])  }}" method="post">
                        @csrf
                        @method('delete')
                        <input name="student_id" value="{{ $student->id }}" type="hidden">
                        <input name="advisor_id" value="{{ $advisor->id }}" type="hidden">
                        <input name="topic" value="{{ $note->topic }}" type="hidden">
                        <input name="note" value="{{ $note->note }}" type="hidden">
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Remove Note
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
          @endforeach
          {{  $notes->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
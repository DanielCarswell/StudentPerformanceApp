@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">{{  $circumstance->name  }} Circumstance Links</p>
    <div class="mb-6">
    <div class="px-16 py-2 flex justify-center">
    <form action="{{ route('circumstances')  }}" method="get">
        <span class="flex justify-center">
            <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                Go Back
            </button>
        </span>
      </form>
    </div>
    <form action="{{  route('circumstance.add_link')  }}" method="post">
        @csrf
        <div class="input-group">
            <input name="circumstance_id" value="{{ $circumstance->id }}" type="hidden">
            <label class="text-xl">Add Helpful Link: </label>
            <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="link" placeholder="Enter Helpful Link">
            <button type="submit" class="bg-purple-400 text-white px-8 py-4 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">Enter Link
              </button>
            @error('link')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </form>
    </div>
    <div class="mb-6">
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Link</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Options</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($circumstance->circumstance_links->count())
          @foreach($circumstance->circumstance_links as $circumstance_link)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $circumstance_link->link  }}</span>
                </td>
                <td>
                    <form action="{{ route('circumstance.links.delete')  }}" method="post">
                        @csrf
                        @method('delete')
                        <input name="link_l" value="{{ $circumstance_link->link }}" type="hidden">
                        <input name="circumstance_id" value="{{ $circumstance->id }}" type="hidden">
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Link
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
          @endforeach
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">Circumstances</p>
    <div class="px-16 py-2 flex justify-center">
      @hasRole(['Admin', 'Advisor'])
        <a href="{{ route('circumstance.add')  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#57c4ad;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Circumstance
                </button>
            </span>
        </a>
      @endhasRole
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Information</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Email Help Links</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($circumstances->count())
          @foreach($circumstances as $circumstance)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $circumstance->name  }}</span>
                </td>
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $circumstance->information  }}</span>
                </td>
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">
                        @foreach($circumstance->circumstance_links as $link)
                            {{$link->link . ', '}}
                        @endforeach
                    </span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                @hasRole(['Admin', 'Advisor'])
                    <form action="{{ route('circumstance.links', $circumstance->id)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                                <i class="fas fa-clipboard-list"></i>&nbsp;&nbsp;Helpful Links
                            </button>
                        </span>
                    </form>
                    <form action="{{ route('circumstance.edit', $circumstance)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#f97316;" class="bg-orange-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                              <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit Circumstance Details
                            </button>
                        </span>
                    </form>
                    <form action="{{ route('circumstance.delete', $circumstance)  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Circumstance
                            </button>
                        </span>
                    </form>
                    @endhasRole
                </td>
            </tr>
          @endforeach

          {{  $circumstances->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">User - {{  $user->fullname  }} Roles</p>
    <div class="px-16 py-2 flex justify-center">
        <a href="{{ route('give_role', $user)  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#57c4ad;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Give Role
                </button>
            </span>
        </a>
        <form action="{{  route('accounts')  }}" method="get">
          @csrf
          <span class="flex justify-center items-center">
              <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                  Go Back
              </button>
          </span>
        </form>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
            <span class="text-gray-300">Role Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Option Links</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($roles->count())
          @foreach($roles as $role)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $role->name  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                @hasRole(['Admin'])
                    <form action="{{ route('remove_role')  }}" method="post">
                        @csrf
                        <input name="user_id" value="{{ $user->id }}" type="hidden">
                        <input name="role_id" value="{{ $role->id }}" type="hidden">
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Remove Role
                            </button>
                        </span>
                    </form>
                @endhasRole
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
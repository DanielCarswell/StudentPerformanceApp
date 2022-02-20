@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">Role - {{  $role->name  }} Permissions</p>
    <div class="px-16 py-2 flex justify-center">
        <a href="{{ route('add_role_permission', $role->id)  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Permission To Role
                </button>
            </span>
        </a>
    </div>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
            <th class="px-16 py-2">
                <span class="text-gray-300">Permission Name</span>
            </th>
            <th class="px-16 py-2">
                <span class="text-gray-300">Slug</span>
            </th>
            <th class="px-16 py-2">
                <span class="text-gray-300">Options</span>
            </th>
        </tr>
      </thead>
      <tbody class="bg-gray-200">
        @if($permissions->count())
          @foreach($permissions as $permission)
            <tr class="bg-white border-4 border-gray-200 ">
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $permission->name  }}</span>
                </td>
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">{{  $permission->slug  }}</span>
                </td>
                <td class="px-16 py-2 flex justify-center">
                    <form action="{{ route('delete_role_permission', [$role->id, $permission->id])  }}" method="post">
                        @csrf
                        <span class="flex justify-center">
                            <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                              <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Permission
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
          @endforeach

          {{  $permissions->links()  }}
        @else
          <p>There is no data</p>
        @endif
      </tbody>
    </table>
  </div>
@endsection
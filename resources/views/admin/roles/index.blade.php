@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">User Roles</p>
    <div class="px-16 py-2 flex justify-center">
    @hasRole(['Admin', 'Moderator'])
        <a href="{{ route('add_role')  }}">
            <span class="flex justify-center">
                <button type="submit" style="background-color:#4dac26;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Role
                </button>
            </span>
        </a>
      @endhasRole
        <a href="{{  route('roles_index')  }}" >
            <span class="flex justify-center">
                <button type="submit" style="background-color:#a6611a;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    <i class="fas fa-circle-notch"></i>&nbsp;&nbsp;Reset Search
                </button>
            </span>
        </a>
    </div>
    <div class="mb-6">
      <form action="{{  route('search_roles')  }}" method="post" role="search">
          @csrf
          <div class="input-group">
              <label class="text-xl">Search Roles: </label>
              <input type="text" class="form-control pt-4 pb-4 pr-12 pl-2 ml-2 text-xl" name="q" placeholder="Search Roles">
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
                    @if($role->id > 8)
                      <form action="{{ route('edit_role', $role)  }}" method="post">
                          @csrf
                          <span class="flex justify-center">
                              <button type="submit" style="background-color:#f97316;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit Role
                              </button>
                          </span>
                      </form>
                      <form action="{{ route('delete_role', $role)  }}" method="post">
                          @csrf
                          <span class="flex justify-center">
                              <button type="submit" style="background-color:#7b3294;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                                <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Role
                              </button>
                          </span>
                      </form>
                      @else
                      <p>Default Role</p>
                    @endif
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
@extends('layouts.admin')

@section('content')
<section class="container mx-auto p-6 font-mono mt-12">
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
    <p class="text-2xl font-extrabold flex justify-center mb-6">Users</p>
    <div class="w-full overflow-x-auto">
    <form action="{{ route('create_student_accounts')  }}" method="get">
        <span class="flex justify-center">
            <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:border-indigo-500 hover:text-black">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Upload Student Accounts - CSV File
            </button>
        </span>
      </form>
      <table class="w-full">
        <thead>
          <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-900 uppercase border-b border-gray-600">
            <th class="px-4 py-3 text-white">Name</th>
            <th class="px-4 py-3 text-white">Email</th>
            <th class="px-4 py-3 text-white">Roles</th>
            <th class="px-4 py-3 text-white">Account Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          @if ($accounts->count())
            @foreach ($accounts as $account)
              <tr class="text-gray-700">
                <td class="px-4 py-3 border">
                    <div class="flex items-center text-sm">
                    <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                        <img class="object-cover w-full h-full rounded-full" src="{{URL::asset('/images/user.png')}}" alt="" loading="lazy" />
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                    </div>
                    <div>
                        <p class="font-semibold text-black">{{  $account->fullname  }}</p>
                    </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-ms border">
                    <span class="font-semibold text-black">{{  $account->email  }}</span>
                </td>
                <td class="px-4 py-3 text-ms border">
                  @foreach($account->roles as $role)
                    <span class="font-semibold text-black">{{  $role->name  }}, </span>
                  @endforeach
                </td>
                <td class="px-4 py-3 text-ms border">
                    <div class="flex justify-center">
                    @hasRole(['Admin', 'Moderator'])
                      @if($account->roles->contains('name', 'Student'))
                        <form action="{{ route('student.advisors', $account->id)  }}" method="post">
                          @csrf
                          <button type="submit" class="bg-indigo-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-clipboard"></i>&nbsp;&nbsp;Manage Advisors
                          </button>
                        </form>
                      @endif
                      <form action="{{  route('user_roles', $account->id)  }}" method="post">
                          @csrf
                          <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-clipboard"></i>&nbsp;&nbsp;User Roles
                          </button>
                      </form>
                      <form action="{{  route('account.edit', $account->acc)  }}">
                          @csrf
                          <button type="submit" class="bg-yellow-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit Account
                          </button>
                      </form>
                    @endhasRole
                    @hasRole(['Admin'])
                      <form action="{{ route('accounts.destroy', $account->acc) }}" method="post">
                          @csrf
                          @method('delete')
                          <button type="submit" class="bg-yellow-800 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete Account
                          </button>
                      </form>
                    @endhasRole
                    </div>
                </td>
              </tr>
            @endforeach
            {{ $accounts->links() }}
            @else
                <p>There is no data</p>
            @endif
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
@extends('layouts.admin')

@section('content')
  <div class="ml-12 mr-12">
    <p class="text-2xl font-extrabold flex justify-center mb-6">View All Permissions</p>
    <table class="min-w-full table-auto rounded-lg">
      <thead class="justify-between">
        <tr class="bg-gray-800">
          <th class="px-16 py-2">
            <span class="text-gray-300">Name</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Slug</span>
          </th>
          <th class="px-16 py-2">
            <span class="text-gray-300">Assigned To Roles</span>
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
                <td>
                    <span class="text-center ml-2 font-semibold flex justify-center">PlaceHolder: Admin, Moderator, Lecturer</span>
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
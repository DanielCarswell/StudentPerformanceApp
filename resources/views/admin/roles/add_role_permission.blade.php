@extends('layouts.admin')

@section('content')
    <div class="flex justify-center mt-48 mb-48 text-extrabold">
        <div class="w-4/12 bg-gray-700 text-white p-6 rounded-lg">
            <h2 class="text-2xl my-4 flex justify-center"><b>Add Permission to Role: {{  $role->name  }}</b></h2>
            <form action="{{ route('add_permission') }}" method="post">
                @csrf
                <div class="mb-4 dropdown box-content inline-block relative text-black flex justify-center">
                    <label for="permissionname" class="sr-only">Select Permission: </label>
                    
                    <select name="permission" id="permission" class="p-3 w-full text-black text-bold bg-gray-200 border-2 @error('permissionname') border-red-500 @enderror rounded-lg" value="{{ old('permissionname') }}">
                        @error('permissionname')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        <option value="Select Permission">Select Permission</option>
                        @if($permissions->count())
                            @foreach($permissions as $permission)
                                <option value="{{  $permission->name  }}">{{  $permission->name  }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-3 rounded font-bold w-full">Add Permission</button>
                </div>
            </form>
            <form action="{{ route('role_permissions', $role)  }}" method="post">
                @csrf
                <span class="flex justify-center items-center">
                    <button type="submit" style="background-color:#4dac26;" class="text-white mt-2 px-4 py-3 rounded font-bold w-full">
                        Go Back
                    </button>
                </span>
            </form>
        </div>
    </div>
@endsection
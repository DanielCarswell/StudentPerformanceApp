@extends('layouts.admin')

@section('content')
    <section class="container mx-auto p-6 font-mono mt-12">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-900 uppercase border-b border-gray-600">
                <th class="px-4 py-3 text-white">Name</th>
                <th class="px-4 py-3 text-white">Email</th>
                <th class="px-4 py-3 text-white">Role</th>
                <th class="px-4 py-3 text-white">Account Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @if ($accounts->count())
                @foreach ($accounts as $account)
                    <x-account-details :account="$account"/>
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
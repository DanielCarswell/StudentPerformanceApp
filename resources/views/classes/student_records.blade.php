@extends('layouts.app')

@section('content')
<section class="container mx-auto p-6 font-mono mt-12">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-900 uppercase border-b border-gray-600">
                <th class="px-4 py-3 text-white">Class Name</th>
                <th class="px-4 py-3 text-white">Grade</th>
                <th class="px-4 py-3 text-white">Attendance</th>
                <th class="px-4 py-3 text-white">Rating</th>
            </tr>
            </thead>
            <tbody class="bg-white">
                @if ($lists->count())
                    @foreach ($lists as $list)
                        <x-student-record :data="$list"/>
                    @endforeach
                    {{ $lists->links() }}
                    @else
                        <p>There is no data</p>
                @endif
            </tbody>
        </table>
        </div>
    </div>
</section>
@endsection
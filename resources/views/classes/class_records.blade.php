@extends('layouts.app')

@section('content')
<section class="container mx-auto p-6 font-mono mt-12">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-900 uppercase border-b border-gray-600">
                <th class="px-4 py-3 text-white">Student Name</th>
                <th class="px-4 py-3 text-white">Grade</th>
                <th class="px-4 py-3 text-white">Attendance</th>
                <th class="px-4 py-3 text-white">Rating</th>
            </tr>
            </thead>
            <tbody class="bg-white">
                @if ($lists->count())
                    @foreach ($lists as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src="{{URL::asset('/images/user.png')}}" alt="" loading="lazy" />
                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-black">{{  $data->fullname  }}</p>
                                    <p class="text-xs text-gray-600">CS Student</p>
                                </div>
                                </div>
                            </td>
                            @if($data->grade >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full">{{  $data->grade  }}</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full">{{  $data->grade  }}</span>
                                </td>
                            @endif
                            @if($data->attendance >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full">{{  $data->attendance  }}</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full">{{  $data->attendance  }}</span>
                                </td>
                            @endif
                            @if($data->attendance < 30 && $data->grade < 30)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full">3</span>
                                </td>
                            @elseif($data->attendance >= 60 && $data->grade >= 70)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full">1</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-blue-400 rounded-full">2</span>
                                </td>
                            @endif
                        </tr>
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
@extends('layouts.app')

@section('content')
<section class="container mx-auto p-6 font-mono mt-12">
    <div class="ml-12 mr-12">
        <p class="text-2xl font-extrabold flex justify-center mb-6">Student {{  $student->fullname  }} Performance</p>
        <div class="px-16 py-2 flex justify-center">
            <a href="{{ route('pdf.student_records', $student->id)  }}">
                <span class="flex justify-center">
                    <button type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:border-purple-500 hover:text-black">
                        <i class="fas fa-plus"></i>&nbsp;&nbsp;Print Basic PDF Of Student Performance
                    </button>
                </span>
            </a>
        </div>
    </div>
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
                    @foreach ($lists as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src="{{URL::asset('/images/user.png')}}" alt="" loading="lazy" />
                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-black">{{  $data->name  }}</p>
                                </div>
                                </div>
                            </td>
                            @if($data->grade >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full">{{  number_format((float)$data->grade, 0, '.', '')  }}%</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full">{{  number_format((float)$data->grade, 0, '.', '')  }}%</span>
                                </td>
                            @endif
                            @if($data->attendance >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full">{{  number_format((float)$data->attendance, 0, '.', '')  }}%</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full">{{  number_format((float)$data->attendance, 0, '.', '')  }}%</span>
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
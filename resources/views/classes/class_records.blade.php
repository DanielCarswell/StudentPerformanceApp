@extends('layouts.app')

@section('content')
<section class="container mx-auto p-6 font-mono mt-12">
    <div class="ml-12 mr-12">
        <p class="text-2xl font-extrabold flex justify-center mb-6">Class Performance</p>
        <div class="px-16 py-2 flex justify-center">
            <form action="{{  route('pdf.class_records', $class->id) }}" method="get">
                @csrf
                <button name="print" type="submit" style="background-color:#57c4ad;" class="text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    Print PDF of Class Records
                </button>
            </form>
            <form action="{{  route('classes') }}" method="get">
                @csrf
                <button name="Go Back" type="submit" class="bg-purple-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    Go Back
                </button>
            </form>
        </div>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-900 uppercase border-b border-gray-600">
                <th class="px-4 py-3 text-white">Student Name</th>
                <th class="px-4 py-3 text-white">Grade</th>
                <th class="px-4 py-3 text-white">Attendance</th>
                <th class="px-4 py-3 text-white">Rating</th>
                <th class="px-4 py-3 text-white">Option Links</th>
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
                                </div>
                                </div>
                            </td>
                            @if($data->grade >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span style="background-color:#57c4ad;" class="px-2 py-1 font-semibold leading-tight rounded-full">{{  number_format((float)$data->grade, 0, '.', '')  }}</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-purple-400 rounded-full">{{  number_format((float)$data->grade, 0, '.', '')  }}</span>
                                </td>
                            @endif
                            @if($data->attendance >= 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span style="background-color:#57c4ad;" class="px-2 py-1 font-semibold leading-tight rounded-full">{{  number_format((float)$data->attendance, 0, '.', '')  }}</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-purple-400 rounded-full">{{  number_format((float)$data->attendance, 0, '.', '')  }}</span>
                                </td>
                            @endif
                            @if($data->attendance < 40 && $data->grade < 40)
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-purple-400 rounded-full">3</span>
                                </td>
                            @elseif($data->attendance >= 60 && $data->grade >= 70)
                                <td class="px-4 py-3 text-ms border">
                                    <span style="background-color:#57c4ad;" class="px-2 py-1 font-semibold leading-tight rounded-full">1</span>
                                </td>
                            @else
                                <td class="px-4 py-3 text-ms border">
                                    <span class="px-2 py-1 font-semibold leading-tight bg-blue-400 rounded-full">2</span>
                                </td>
                            @endif
                            <td class="px-4 py-3 text-ms border">
                                <form action="{{ route('classes.student_records', $data->id)  }}" method="post">
                                    @csrf
                                    <span class="flex justify-center">
                                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                                        View Students Records <i class="fas fa-plus"></i>
                                        </button>
                                    </span>
                                </form>
                            </td>
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
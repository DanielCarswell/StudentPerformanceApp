@props(['data' => $data])

<tr class="text-gray-700">
    <td class="px-4 py-3 border">
        <div class="flex items-center text-sm">
        <div class="relative w-8 h-8 mr-3 rounded-full md:block">
            <img class="object-cover w-full h-full rounded-full" src="{{URL::asset('/images/user.png')}}" alt="" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
        <div>
            <p class="font-semibold text-black">{{  $data->name  }}</p>
            <p class="text-xs text-gray-600">Course Computing Science</p>
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
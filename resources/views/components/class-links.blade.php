@props(['class' => $class])

<tr class="bg-white border-4 border-gray-200 ">
    <td>
        <span class="text-center ml-2 font-semibold flex justify-center">{{  $class->name  }}</span>
    </td>
    @if($class->average_grade >= 50)
        <td class="ml-128 mr-128">
            <span class="px-2 py-1 font-semibold leading-tight bg-green-400 rounded-full flex justify-center">{{  $class->average_grade  }}</span>
        </td>
    @else
        <td class="ml-128 mr-128">
            <span class="px-2 py-1 font-semibold leading-tight bg-red-400 rounded-full flex justify-center">{{  $class->average_grade  }}</span>
        </td>
    @endif
    <td class="px-16 py-2 flex justify-center">
        <form action="{{ route('classes.class_records', $class)  }}" method="post">
            @csrf
            <span class="flex justify-center">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    View Class Records <i class="fas fa-plus"></i>
                </button>
            </span>
        </form>
        <form action="{{ route('graph.class_grades', $class)  }}" method="post">
            @csrf
            <span class="flex justify-center">
                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 text-black hover:text-black">
                    View As Graph <i class="fas fa-star"></i>
                </button>
            </span>
        </form>
    </td>
</tr>
@props(['class' => $class])

<div class="mb-4">
    <p class="mb-2">
        <div class="grid grid-cols-4 gap-4 justify-items-stretch auto-rows-fr h-24">
            <div class=" text-2xl font-bold bg-stripes bg-gray-500 rounded-2xl flex justify-center items-center px-4 py-2">{{ $class->name }}</div>
            @if ($class->grade > 50)
                <div class=" text-2xl font-bold bg-stripes bg-green-500 rounded-2xl flex justify-center items-center px-4 py-2">{{ $class->grade }}</div>
            @else
                <div class=" text-2xl font-bold bg-stripes bg-red-500 rounded-2xl flex justify-center items-center px-4 py-2">{{ $class->grade }}</div>
            @endif
            @if ($class->attendance > 50)
                <div class=" text-2xl font-bold bg-stripes bg-green-500 rounded-2xl flex justify-center items-center px-4 py-2">{{ $class->attendance }}</div>
            @else
                <div class=" text-2xl font-bold bg-stripes bg-red-500 rounded-2xl flex justify-center items-center px-4 py-2">{{ $class->attendance }}</div>
            @endif
            @if ($class->attendance > 80 && $class->grade > 60)
                <div class=" text-2xl font-bold bg-stripes bg-green-500 rounded-2xl flex justify-center items-center px-4 py-2"></div>
            @elseif ($class->attendance <= 20 && $class->grade <= 20)
                <div class=" text-2xl font-bold bg-stripes bg-black rounded-2xl flex justify-center items-center px-4 py-2"></div>
            @else
                <div class=" text-2xl font-bold bg-stripes bg-blue-300 rounded-2xl flex justify-center items-center px-4 py-2"></div>
            @endif
        </div>
    </p>
</div>
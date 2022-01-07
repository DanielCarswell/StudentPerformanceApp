@props(['account' => $account])

<tr class="text-gray-700">
    <td class="px-4 py-3 border">
        <div class="flex items-center text-sm">
        <div class="relative w-8 h-8 mr-3 rounded-full md:block">
            <img class="object-cover w-full h-full rounded-full" src="{{URL::asset('/images/user.png')}}" alt="" loading="lazy" />
            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
        </div>
        <div>
            <p class="font-semibold text-black">{{  $account->fullname  }}</p>
            <p class="text-xs text-gray-600">{{  $account->role_name  }}</p>
        </div>
        </div>
    </td>
    <td class="px-4 py-3 text-ms border">
        <span class="font-semibold text-black">{{  $account->email  }}</span>
    </td>
    <td class="px-4 py-3 text-ms border">
        <span class="font-semibold text-black">{{  $account->role_name  }}</span>
    </td>
    <td class="px-4 py-3 text-ms border">
        <div class="flex justify-center">
            <form>
                @csrf
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    View Profile <i class="fas fa-plus"></i>
                </button>
            </form>
            <form>
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    Edit Account <i class="fas fa-pencil-alt"></i>
                </button>
            </form>
            <form action="{{ route('accounts.destroy', $account->acc) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="bg-yellow-800 text-white px-4 py-2 border rounded-md hover:bg-white hover:border-indigo-500 hover:text-black">
                    Delete Account <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
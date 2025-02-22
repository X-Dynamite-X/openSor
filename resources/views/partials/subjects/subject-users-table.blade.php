@forelse($users as $user)
    <tr class="hover:bg-white hover:bg-opacity-5">
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->email }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">
            {{ $user->pivot->mark ?? 'Not assigned' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button onclick="editUserMark({{ $user->id }}, '{{ $user->name }}', {{ $user->pivot->mark ?? 'null' }})"
                    class="text-indigo-300 hover:text-indigo-100">
                <i class="fas fa-edit"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-4 text-center text-white">
            <div class="flex flex-col items-center justify-center space-y-2">
                <i class="fas fa-users text-4xl text-white text-opacity-40"></i>
                <p class="text-white text-opacity-60">No users found</p>
            </div>
        </td>
    </tr>
@endforelse

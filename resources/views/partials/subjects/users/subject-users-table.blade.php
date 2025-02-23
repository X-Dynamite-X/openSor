@forelse($users as $user)
    <tr class="hover:bg-white hover:bg-opacity-5" data-user-id="{{ $user->id }}">
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->email }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white user-mark">
            {{ $user->pivot->mark ?? 'Not assigned' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-white">
            <div class="flex space-x-2 justify-end">
                <button onclick="openEditMarkModal({{ $user->id }}, '{{ $user->name }}', {{ $user->pivot->mark ?? 'null' }})"
                        class="p-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="openRemoveUserModal({{ $user->id }}, '{{ $user->name }}')"
                        class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-user-minus"></i>
                </button>
            </div>
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

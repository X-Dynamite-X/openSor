@forelse($users as $user)
    <tr class="hover:bg-white hover:bg-opacity-5 transition-colors duration-200" data-user-id="{{ $user->id }}">
        <td class="px-6 py-4 whitespace-nowrap text-white user-id">{{ $user->id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white user-name">{{ $user->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white user-email">{{ $user->email }}</td>
        <td class="px-6 py-4 whitespace-nowrap user-status">
            @if($user->permissions[0]->name === 'active')
                <span class="px-3 py-1 inline-flex items-center justify-center text-xs leading-5 font-semibold rounded-full bg-green-100 bg-opacity-20 text-green-400 border border-green-400 border-opacity-20 ">
                    <i class="fas fa-check-circle mr-1"></i>
                    Active
                </span>
            @else
                <span class="px-3 py-1 inline-flex items-center justify-center text-xs leading-5 font-semibold rounded-full bg-red-100 bg-opacity-20 text-red-400 border border-red-400 border-opacity-20">
                    <i class="fas fa-times-circle mr-1"></i>
                    Not Active
                </span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->created_at->format('Y-m-d') }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white">
            <div class="flex space-x-2">
                <button onclick="openEditModal({{ json_encode($user) }})"
                    class="p-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="openDeleteModal({{ $user->id }})"
                    class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-white">
            <div class="flex flex-col items-center justify-center space-y-2">
                <i class="fas fa-search text-4xl text-white text-opacity-40"></i>
                <p class="text-white text-opacity-60">No users found</p>
            </div>
        </td>
    </tr>
@endforelse

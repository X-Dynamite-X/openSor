@forelse($subjects as $subject)
    <tr class="hover:bg-white hover:bg-opacity-5 transition-colors duration-200" data-subject-id="{{ $subject->id }}">
        <td class="px-6 py-4 whitespace-nowrap text-white subject-id">{{ $subject->id }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white subject-name">{{ $subject->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white subject-success_mark">{{ $subject->success_mark }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-white subject-full_mark">{{ $subject->full_mark }}</td>


         <td class="px-6 py-4 whitespace-nowrap text-white">
            <div class="flex space-x-2">
                <button onclick="showSubjectUsers({{ $subject->id }})"
                        class="p-2 rounded-lg bg-green-500 hover:bg-green-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-users"></i>
                </button>
                <button onclick="openEditModal({{ json_encode($subject) }})"
                        class="p-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="openDeleteModal({{ $subject->id }})"
                        class="p-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition duration-200 transform hover:scale-105">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-white">
            <div class="flex flex-col items-center justify-center space-y-2">
                <i class="fas fa-search text-4xl text-white text-opacity-40"></i>
                <p class="text-white text-opacity-60">No Subject found</p>
            </div>
        </td>
    </tr>
@endforelse


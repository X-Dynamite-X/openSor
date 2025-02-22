<tr data-subject-id="{{ $subject->id }}">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
        {{ $subject->id }}
    </td>e
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 subject-name">
        {{ $subject->name }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 subject-success_mark">
        {{ $subject->success_mark }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 subject-full_mark">
        {{ $subject->full_mark }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <button onclick='openEditModal(@json($subject))' class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
            Edit
        </button>
        <button onclick="openDeleteModal({{ $subject->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
            Delete
        </button>
    </td>
</tr>

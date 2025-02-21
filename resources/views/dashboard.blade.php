<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 dark:text-gray-300 mr-4">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Search Bar -->
        <div class="mb-6">
            <input type="text"
                id="searchInput"
                placeholder="Search users..."
                class="w-full sm:w-96 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="usersTableBody">
                        @include('partials.users-table', ['users' => $users])
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4" id="pagination">
                @include('partials.pagination', ['users' => $users])
            </div>
        </div>
    </main>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Edit User</h3>
                <form id="editForm" class="mt-4">
                    <input type="hidden" id="editUserId">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Name</label>
                        <input type="text" id="editName" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="editEmail" class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Confirm Delete</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-gray-500 dark:text-gray-400">Are you sure you want to delete this user?</p>
                </div>
                <div class="flex justify-center gap-3">
                    <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded-lg">Delete</button>
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteId = null;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let searchTimer;

            $('#searchInput').on('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => fetchUsers(), 300);
            });

            // إضافة مستمعي الأحداث لروابط الصفحات عند تحميل الصفحة
            $('#pagination a').on('click', function(e) {
                e.preventDefault();
                fetchUsers($(this).attr('href'));
            });
        });

        function fetchUsers(page = null) {
            const searchTerm = $('#searchInput').val();
            let url = '{{ route("dashboard.users") }}';

            if (page) {
                url = page;
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    $('#usersTableBody').html(response.html);
                    $('#pagination').html(response.pagination);
                    $('#pagination a').on('click', function(e) {
                        e.preventDefault();
                        fetchUsers($(this).attr('href'));
                    });
                }
            });
        }

        function openEditModal(user) {
            // استخدام البيانات من الجدول مباشرة بدلاً من كائن user
            const row = $(`tr[data-user-id="${user.id}"]`);
            const name = row.find('.user-name').text();
            const email = row.find('.user-email').text();
            const isAdmin = row.find('.user-role').text().trim() === 'Admin';

            $('#editUserId').val(user.id);
            $('#editName').val(name);
            $('#editEmail').val(email);
            if ($('#editIsAdmin').length) {  // إذا كان حقل is_admin موجود
                $('#editIsAdmin').prop('checked', isAdmin);
            }
            $('#editModal').removeClass('hidden');
        }

        function closeEditModal() {
            $('#editModal').addClass('hidden');
        }

        function openDeleteModal(userId) {
            currentDeleteId = userId;
            $('#deleteModal').removeClass('hidden');
        }

        function closeDeleteModal() {
            $('#deleteModal').addClass('hidden');
            currentDeleteId = null;
        }

        function confirmDelete() {
            if (currentDeleteId) {
                $.ajax({
                    url: `/users/${currentDeleteId}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            // حذف الصف من الجدول
                            $(`tr[data-user-id="${currentDeleteId}"]`).remove();
                            
                            // جلب مستخدم جديد إذا كان هناك المزيد من المستخدمين
                            $.ajax({
                                url: '{{ route("dashboard.users") }}',
                                type: 'GET',
                                data: {
                                    get_next_user: true,
                                    current_page: $('.pagination .active span').text()
                                },
                                success: function(response) {
                                    if (response.new_user_html) {
                                        // إضافة المستخدم الجديد إلى نهاية الجدول
                                        $('#usersTableBody').append(response.new_user_html);
                                    }
                                    // تحديث الترقيم في الجدول إذا لزم الأمر
                                    updateTableNumbers();
                                }
                            });

                            // إغلاق نافذة التأكيد
                            closeDeleteModal();
                            
                            // إظهار رسالة نجاح
                            showAlert('User deleted successfully', 'success');
                        }
                    },
                    error: function(xhr) {
                        showAlert('Error deleting user', 'error');
                    }
                });
            }
        }

        // دالة لتحديث أرقام الصفوف في الجدول
        function updateTableNumbers() {
            const currentPage = parseInt($('.pagination .active span').text()) || 1;
            const startingNumber = (currentPage - 1) * 10;
            
            $('#usersTableBody tr').each(function(index) {
                $(this).find('td:first').text(startingNumber + index + 1);
            });
        }

        // إضافة معالج حدث تقديم نموذج التعديل
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const userId = $('#editUserId').val();

            $.ajax({
                url: `/users/${userId}`,
                type: 'PUT',
                data: {
                    name: $('#editName').val(),
                    email: $('#editEmail').val(),
                },
                success: function(response) {
                    if (response.success) {
                        // تحديث الصف في الجدول مباشرة
                        const row = $(`tr[data-user-id="${userId}"]`);
                        row.find('.user-name').text(response.user.name);
                        row.find('.user-email').text(response.user.email);

                        // إغلاق النافذة المنبثقة
                        closeEditModal();

                        // إظهار رسالة نجاح (اختياري)
                        showAlert('User updated successfully', 'success');
                    }
                },
                error: function(xhr) {
                    // إظهار رسالة خطأ (اختياري)
                    showAlert('Error updating user', 'error');
                }
            });
        });

        // دالة مساعدة لإظهار التنبيهات (اختياري)
        function showAlert(message, type = 'success') {
            const alertDiv = $(`
                <div class="fixed top-4 right-4 px-4 py-2 rounded-lg ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white">
                    ${message}
                </div>
            `);

            $('body').append(alertDiv);

            // إخفاء التنبيه بعد 3 ثواني
            setTimeout(() => {
                alertDiv.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
</body>
</html>

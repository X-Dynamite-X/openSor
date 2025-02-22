@extends('Layouts.admin')
@section('content')
    <!-- Your existing table content goes here -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header with Search and Add Button -->
        <div class="flex justify-between items-center mb-6">
            <!-- Search Bar -->
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Search users..."
                    class="w-full sm:w-96 pl-10 pr-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 backdrop-blur-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Add User Button -->
            <button onclick="openAddModal()"
                class="flex items-center space-x-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded-lg text-white transition duration-200 transform hover:scale-105">
                <i class="fas fa-user-plus"></i>
                <span>Add User</span>
            </button>
        </div>

        <!-- Content Area -->
        <div
            class="bg-white bg-opacity-10 backdrop-blur-lg shadow-lg rounded-lg overflow-hidden border border-white border-opacity-20">

            <div
                class="bg-white bg-opacity-10 backdrop-blur-lg shadow-lg rounded-lg overflow-hidden border border-white border-opacity-20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white divide-opacity-20">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Active </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Created At</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white divide-opacity-20" id="usersTableBody">
                            @include('partials.users.users-table', ['users' => $users])
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4" id="pagination">
                    @include('partials.users.pagination', ['users' => $users])
                </div>
            </div>
        </div>
    </div>
@endsection


@section('model')
    <!-- Add User Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Add New User</h3>
                <form id="addUserForm" class="mt-4">
                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Name</label>
                        <input type="text" id="addName" required
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Email</label>
                        <input type="email" id="addEmail" required
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Password</label>
                        <input type="password" id="addPassword" required
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-6">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="addActive" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                            <span class="ml-3 text-sm font-medium text-white status-text">Active</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-purple-500 hover:bg-purple-600 text-white transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-6 w-full max-w-md transform transition-all">
            <!-- Modal Content -->
            <div
                class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl shadow-2xl border border-white border-opacity-20">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-white border-opacity-20">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Edit User</h3>
                        <button onclick="closeEditModal()"
                            class="text-white opacity-70 hover:opacity-100 transition-opacity">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <form id="editForm" class="space-y-4">
                        <input type="hidden" id="editUserId">

                        <!-- Name Field -->
                        <div>
                            <label for="editName" class="block text-white text-sm font-medium mb-2">
                                <i class="fas fa-user mr-2"></i>Name
                            </label>
                            <input type="text" id="editName"
                                class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="editEmail" class="block text-white text-sm font-medium mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </label>
                            <input type="email" id="editEmail"
                                class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        </div>

                        <!-- Active Status Toggle -->
                        <div class="flex items-center justify-between">
                            <label for="editActive" class="flex items-center cursor-pointer">
                                <div class="mr-3">
                                    <span class="text-white text-sm font-medium">
                                        <i class="fas fa-shield-alt mr-2"></i>Account Status
                                    </span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="editActive" class="sr-only">
                                    <div class="w-10 h-4 bg-white bg-opacity-20 rounded-full shadow-inner"></div>
                                    <div
                                        class="dot absolute w-6 h-6 bg-purple-500 rounded-full shadow -left-1 -top-1 transition-all duration-300 transform">
                                    </div>
                                </div>
                                <span class="ml-3 text-white text-sm font-medium status-text">Not Active</span>
                            </label>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-white border-opacity-20">
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500 bg-opacity-50 hover:bg-opacity-70 text-white transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit" form="editForm"
                            class="px-4 py-2 rounded-lg bg-purple-500 hover:bg-purple-600 text-white transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3 text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-4">Confirm Delete</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-white text-opacity-80">Are you sure you want to delete this user? This action cannot
                        be undone.</p>
                </div>
                <div class="flex justify-center space-x-3 mt-4">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white transition duration-200">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()"
                        class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition duration-200">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection("model")
@section('loding')
    <!-- Loading Indicator -->
    <div id="loadingIndicator"
        class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-white"></div>
    </div>
@endsection("loding")

@section('script')
    <script>
        let currentDeleteId = null;

        function showLoading() {
            $('#loadingIndicator').removeClass('hidden');
        }

        function hideLoading() {
            $('#loadingIndicator').addClass('hidden');
        }

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
            let url = '{{ route('dashboard.users') }}';

            if (page) {
                url = page;
            }
            // showLoading();

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
                },
                error: function(xhr, status, error) {
                    showAlert('Error loading users', 'error');
                },
                complete: function() {
                    hideLoading();
                }
            });
        }

        function showAlert(message, type = 'success') {
            const alertDiv = $(`
                <div class="fixed top-4 right-4 px-6 py-3 rounded-lg ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white shadow-lg z-50 animate-fade-in-down">
                    <div class="flex items-center space-x-2">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `);

            $('body').append(alertDiv);
            setTimeout(() => {
                alertDiv.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        function openEditModal(user) {
            const row = $(`tr[data-user-id="${user.id}"]`);
            const name = row.find('.user-name').text();
            const email = row.find('.user-email').text();
            const isActive = row.find('.user-status').text().trim() === 'Active';

            // تعيين قيم الحقول
            $('#editUserId').val(user.id);
            $('#editName').val(name.trim());
            $('#editEmail').val(email.trim());

            // تحديث حالة التفعيل
            $('#editActive').prop('checked', isActive);
            // استخدام jQuery للعثور على عنصر النص
            const statusText = $('#editActive').closest('label').find('.status-text');
            statusText.text(isActive ? 'Active' : 'Not Active');

            // تحديث حالة الأدمن إذا كان الحقل موجود
            if ($('#editIsAdmin').length) {
                $('#editIsAdmin').prop('checked', isAdmin);
            }

            // إظهار المودال مع تأثير انتقالي
            $('#editModal')
                .removeClass('hidden')
                .addClass('animate-fade-in');
        }

        function closeEditModal() {
            $('#editModal').addClass('hidden');
        }

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const userId = $('#editUserId').val();
            const isActive = $('#editActive').is(':checked');

            $.ajax({
                url: `/users/${userId}`,
                type: 'PUT',
                data: {
                    name: $('#editName').val(),
                    email: $('#editEmail').val(),
                    is_active: isActive ? 'active' : 'not_active',
                },
                success: function(response) {
                    if (response.success) {
                        // تحديث الصف في الجدول مباشرة
                        const row = $(`tr[data-user-id="${userId}"]`);
                        row.find('.user-name').text(response.user.name);
                        row.find('.user-email').text(response.user.email);

                        // تحديث حالة التفعيل في الجدول
                        const statusCell = row.find('.user-status');
                        if (isActive) {
                            statusCell.html(`
                                <span class="px-3 py-1 inline-flex items-center justify-center text-xs leading-5 font-semibold rounded-full bg-green-100 bg-opacity-20 text-green-400 border border-green-400 border-opacity-20">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            `);
                        } else {
                            statusCell.html(`
                                <span class="px-3 py-1 inline-flex items-center justify-center text-xs leading-5 font-semibold rounded-full bg-red-100 bg-opacity-20 text-red-400 border border-red-400 border-opacity-20">
                                    <i class="fas fa-times-circle mr-1"></i>Not Active
                                </span>
                            `);
                        }

                        // إغلاق المودال
                        closeEditModal();

                        // إظهار رسالة نجاح
                        showAlert('User updated successfully', 'success');
                    }
                },
                error: function(xhr) {
                    showAlert('Error updating user', 'error');
                }
            });
        });

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
                                url: '{{ route('dashboard.users') }}',
                                type: 'GET',
                                data: {
                                    get_next_user: true,
                                    current_page: $('.pagination .active span').text()
                                },
                                success: function(response) {
                                    if (response.new_user_html) {
                                        // $('#usersTableBody').append(response.new_user_html);
                                        //  fetchUsers();
                                    }
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

        function openAddModal() {
            $('#addModal').removeClass('hidden');
            $('#addName').val('');
            $('#addEmail').val('');
            $('#addPassword').val('');
            $('#addActive').prop('checked', true);
        }

        function closeAddModal() {
            $('#addModal').addClass('hidden');
        }

        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/users',
                type: 'POST',
                data: {
                    name: $('#addName').val(),
                    email: $('#addEmail').val(),
                    password: $('#addPassword').val(),
                    is_active: $('#addActive').is(':checked') ? 'active' : 'not_active',
                },
                success: function(response) {
                    if (response.success) {
                        // Refresh the table
                        // fetchUsers();

                        // Close modal
                        closeAddModal();

                        // Show success message
                        showAlert('User added successfully', 'success');
                    }
                },
                error: function(xhr) {
                    showAlert('Error adding user', 'error');
                }
            });
        });

        $('#addActive').on('change', function() {
            const statusText = $(this).closest('label').find('.status-text');
            statusText.text(this.checked ? 'Active' : 'Not Active');
        });
    </script>
    <style>
        /* Custom Toggle Switch Styles */
        #editActive:checked~.dot {
            transform: translateX(100%);
            background-color: #10B981;
            /* green-500 */
        }

        #editActive:checked~.status-text {
            color: #10B981;
        }

        .status-text {
            color: #EF4444;
            /* red-500 */
        }
    </style>
    <script>
        // Update status text based on toggle
        document.getElementById('editActive').addEventListener('change', function() {
            const statusText = this.closest('label').querySelector('.status-text');
            statusText.textContent = this.checked ? 'Active' : 'Not Active';
        });
    </script>
@endsection("script")

@extends('Layouts.admin')
@section('content')
 
                <!-- Your existing table content goes here -->
                <div
                    class="bg-white bg-opacity-10 backdrop-blur-lg shadow-lg rounded-lg overflow-hidden border border-white border-opacity-20">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white divide-opacity-20">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Created At</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white divide-opacity-20" id="usersTableBody">
                                @include('partials.users-table', ['users' => $users])
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4" id="pagination">
                        @include('partials.pagination', ['users' => $users])
                    </div>
                </div>
       
@endsection


@section('model')
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Edit User</h3>
                <form id="editForm" class="mt-4">
                    <input type="hidden" id="editUserId">
                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Name</label>
                        <input type="text" id="editName"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="mb-6">
                        <label class="block text-white text-sm font-medium mb-2">Email</label>
                        <input type="email" id="editEmail"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-purple-500 hover:bg-purple-600 text-white transition duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
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
@endsection("model")

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
            // استخدام البيانات من الجدول مباشرة بدلاً من كائن user

            const row = $(`tr[data-user-id="${user.id}"]`);
            const name = row.find('.user-name').text();
            const email = row.find('.user-email').text();
            const isAdmin = row.find('.user-role').text().trim() === 'Admin';
            $('#editUserId').val(user.id);
            $('#editName').val(user.name.trim());
            $('#editEmail').val(user.email.trim());
            if ($('#editIsAdmin').length) { // إذا كان حقل is_admin موجود
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
@endsection("script")

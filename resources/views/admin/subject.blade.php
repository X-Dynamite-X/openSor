@extends('Layouts.admin')
@section('content')
    <!-- Your existing table content goes here -->
    <div class="container mx-auto px-6 py-8">
        <!-- Header with Add Button -->
        <div class="flex justify-between items-center mb-6">
            <!-- Search Bar -->
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Search Subject..."
                    class="w-full sm:w-96 pl-10 pr-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 backdrop-blur-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Add Subject Button -->
            <button onclick="openAddModal()"
                class="flex items-center space-x-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded-lg text-white transition duration-200 transform hover:scale-105">
                <i class="fas fa-plus"></i>
                <span>Add Subject</span>
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
                                    Success Mark</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Full Mark</th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white divide-opacity-20" id="subjectsTableBody">
                            @include('partials.subjects.subjects-table', ['subjects' => $subjects])
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4" id="pagination">
                    @include('partials.subjects.pagination', ['subjects' => $subjects])
                </div>
            </div>
        </div>
    </div>
@endsection


@section('model')
    <!-- Add Subject Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Add New Subject</h3>

                <!-- Error Container -->
                <div id="addSubjectErrors"
                    class="hidden mb-4 p-4 rounded-lg bg-red-500 bg-opacity-20 border border-red-500 text-red-100">
                    <ul class="list-disc list-inside text-sm"></ul>
                </div>

                <form id="addForm" class="mt-4">
                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Name</label>
                        <input type="text" id="addName" required
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="name"></span>
                    </div>

                    <div class="mb-6">
                        <label class="block text-white text-sm font-medium mb-2">Success Mark</label>
                        <input type="number" id="addSuccessMark" required min="0" max="100"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="success_mark"></span>
                    </div>

                    <div class="mb-6">
                        <label class="block text-white text-sm font-medium mb-2">Full Mark</label>
                        <input type="number" id="addFullMark" required min="0" max="100"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="full_mark"></span>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()"
                            class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-purple-500 hover:bg-purple-600 text-white transition duration-200">
                            Add Subject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div
            class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Edit Subject</h3>

                <!-- Error Container -->
                <div id="editSubjectErrors"
                    class="hidden mb-4 p-4 rounded-lg bg-red-500 bg-opacity-20 border border-red-500 text-red-100">
                    <ul class="list-disc list-inside text-sm"></ul>
                </div>

                <form id="editForm" class="mt-4">
                    <input type="hidden" id="editSubjectId">

                    <div class="mb-4">
                        <label class="block text-white text-sm font-medium mb-2">Name</label>
                        <input type="text" id="editName"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="name"></span>
                    </div>

                    <div class="mb-6">
                        <label class="block text-white text-sm font-medium mb-2">Success Mark</label>
                        <input type="number" id="editSuccessMark"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="success_mark"></span>
                    </div>
                    <div class="mb-6">
                        <label class="block text-white text-sm font-medium mb-2">Full Mark</label>
                        <input type="number" id="editFullMark"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="full_mark"></span>
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
                    <p class="text-white text-opacity-80">Are you sure you want to delete this subject? This action cannot
                        be undone.</p>
                </div>
                <div class="flex justify-center space-x-3 mt-4">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white transition duration-200">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()"
                        class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition duration-200">
                        Delete Subject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Modal -->
    <div id="usersModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full">
        <div
            class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Registered Users</h3>
                    <button onclick="closeUsersModal()" class="text-white hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <div class="mb-4 relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="userSearchInput" placeholder="Search users..."
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <table class="min-w-full divide-y divide-white divide-opacity-20">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Mark</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Action</th>
                            </tr>
                        </thead>
                        <tbody id="subjectUsersTableBody" class="divide-y divide-white divide-opacity-20">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                    <!-- Pagination Container -->
                    <div id="subjectUsersPagination" class="mt-4 flex justify-center">
                        <!-- Pagination links will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Mark Modal -->
    <div id="editMarkModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-gradient-to-b from-gray-800 to-gray-900 border-gray-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Edit Student Mark</h3>
                    <button onclick="closeEditMarkModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editMarkForm" class="space-y-4">
                    <input type="hidden" id="editMarkUserId">
                    <div>
                        <label class="block text-gray-300 text-sm font-medium mb-2">Student Name</label>
                        <div id="editMarkUserName" class="bg-gray-700 bg-opacity-50 rounded-lg px-4 py-2.5 text-white"></div>
                    </div>
                    <div>
                        <label for="editMarkValue" class="block text-gray-300 text-sm font-medium mb-2">Mark</label>
                        <input type="number" id="editMarkValue"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-600 bg-gray-700 bg-opacity-50 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            min="0" max="100" placeholder="Enter mark (0-100)">
                        <span class="error-message text-red-400 text-sm mt-1 hidden" data-for="mark"></span>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeEditMarkModal()"
                            class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white transition duration-200 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Remove User Modal -->
    <div id="removeUserModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-gradient-to-b from-gray-800 to-gray-900 border-gray-700">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Remove Student</h3>
                    <button onclick="closeRemoveUserModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <input type="hidden" id="removeUserId">
                <div class="mb-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-red-500 bg-opacity-20 rounded-full p-3">
                            <i class="fas fa-user-minus text-3xl text-red-500"></i>
                        </div>
                    </div>
                    <p class="text-center text-gray-300">
                        Are you sure you want to remove
                        <span id="removeUserName" class="font-semibold text-white"></span>
                        from this subject?
                    </p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button onclick="closeRemoveUserModal()"
                        class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white transition duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button id="confirmRemoveBtn" onclick="confirmRemoveUser()"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition duration-200 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Remove
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
        let currentSubjectId = null;
        let editMarkUserId = null;
        let removeUserId = null;

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
                searchTimer = setTimeout(() => fetchSubjects(), 300);
            });

            // إضافة مستمعي الأحداث لروابط الصفحات عند تحميل الصفحة
            $('#pagination a').on('click', function(e) {
                e.preventDefault();
                fetchSubjects($(this).attr('href'));
            });
        });

        function fetchSubjects(page = null) {
            const searchTerm = $('#searchInput').val();
            let url = '{{ route('dashboard.subject') }}';

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
                    $('#subjectsTableBody').html(response.html);
                    $('#pagination').html(response.pagination);
                    $('#pagination a').on('click', function(e) {
                        e.preventDefault();
                        fetchSubjects($(this).attr('href'));
                    });
                },
                error: function(xhr, status, error) {
                    showAlert('Error loading subjects', 'error');
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

        function openEditModal(subject) {
            resetEditSubjectErrors();

            $('#editSubjectId').val(subject.id);
            $('#editName').val(subject.name.trim());
            $('#editSuccessMark').val(subject.success_mark);
            $('#editFullMark').val(subject.full_mark);

            $('#editModal').removeClass('hidden');
        }

        function closeEditModal() {
            $('#editModal').addClass('hidden');
            resetEditSubjectErrors();
            $('#editForm')[0].reset();
        }

        // معالجة تقديم نموذج التعديل
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            resetEditSubjectErrors();

            const subjectId = $('#editSubjectId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalContent = submitBtn.html();

            // تغيير حالة الزر إلى حالة التحميل
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...').prop('disabled', true);

            $.ajax({
                url: `/subject/${subjectId}`,
                type: 'PUT',
                data: {
                    name: $('#editName').val(),
                    success_mark: $('#editSuccessMark').val(),
                    full_mark: $('#editFullMark').val(),

                },
                success: function(response) {
                    if (response.success) {
                        // تحديث الصف في الجدول مباشرة
                        const row = $(`tr[data-subject-id="${subjectId}"]`);
                        row.find('.subject-name').text(response.subject.name);
                        row.find('.subject-success_mark').text(response.subject.success_mark);
                        row.find('.subject-full_mark').text(response.subject.full_mark);


                        // إغلاق النافذة المنبثقة
                        closeEditModal();

                        // إظهار رسالة نجاح
                        showAlert('Subject updated successfully', 'success');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    if (response.errors) {
                        displayEditSubjectErrors(response.errors);
                    } else if (response.message) {
                        displayEditSubjectErrors(response.message);
                    } else {
                        displayEditSubjectErrors('An error occurred while updating the subject');
                    }
                },
                complete: function() {
                    // إعادة الزر إلى حالته الأصلية
                    submitBtn.html(originalContent).prop('disabled', false);
                }
            });
        });

        function openDeleteModal(subjectId) {
            currentDeleteId = subjectId;
            $('#deleteModal').removeClass('hidden');
        }

        function closeDeleteModal() {
            $('#deleteModal').addClass('hidden');
            currentDeleteId = null;
        }

        function confirmDelete() {
            if (currentDeleteId) {
                $.ajax({
                    url: `/subject/${currentDeleteId}`,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            // حذف الصف من الجدول
                            $(`tr[data-subject-id="${currentDeleteId}"]`).remove();

                            // جلب مستخدم جديد إذا كان هناك المزيد من المستخدمين
                            $.ajax({
                                url: '{{ route('dashboard.subject') }}',
                                type: 'GET',
                                data: {
                                    get_next_subject: true,
                                    current_page: $('.pagination .active span').text()
                                },
                                success: function(response) {
                                    if (response.new_subject_html) {
                                        // $('#subjectsTableBody').append(response.new_subject_html);
                                        //  fetchSubjects();
                                    }
                                }
                            });

                            // إغلاق نافذة التأكيد
                            closeDeleteModal();

                            // إظهار رسالة نجاح
                            showAlert('Subject deleted successfully', 'success');
                        }
                    },
                    error: function(xhr) {
                        showAlert('Error deleting subject', 'error');
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

        // دالة إعادة تعيين أخطاء النموذج
        function resetAddSubjectErrors() {
            $('#addSubjectErrors').addClass('hidden').find('ul').empty();
            $('#addForm .error-message').addClass('hidden').text('');
            $('#addForm input').removeClass('border-red-500');
        }

        // دالة عرض أخطاء النموذج
        function displayAddSubjectErrors(errors) {
            const errorContainer = $('#addSubjectErrors');
            const errorList = errorContainer.find('ul');
            errorList.empty();

            if (typeof errors === 'string') {
                // إذا كان الخطأ نص واحد
                errorList.append(`<li>${errors}</li>`);
                errorContainer.removeClass('hidden');
                return;
            }

            // معالجة الأخطاء لكل حقل
            Object.keys(errors).forEach(field => {
                const errorMsg = errors[field][0]; // أخذ أول رسالة خطأ

                // إضافة الخطأ إلى القائمة العامة
                errorList.append(`<li>${errorMsg}</li>`);

                // إظهار الخطأ تحت الحقل المعني
                const errorSpan = $(`#addForm .error-message[data-for="${field}"]`);
                if (errorSpan.length) {
                    errorSpan.removeClass('hidden').text(errorMsg);
                    $(`#add${field.charAt(0).toUpperCase() + field.slice(1)}`).addClass('border-red-500');
                }
            });

            errorContainer.removeClass('hidden');
        }

        function openAddModal() {
            resetAddSubjectErrors();
            $('#addForm')[0].reset();
            $('#addModal').removeClass('hidden');
        }

        function closeAddModal() {
            $('#addModal').addClass('hidden');
            resetAddSubjectErrors();
            $('#addForm')[0].reset();
        }

        // معالجة تقديم النموذج
        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            resetAddSubjectErrors();

            const submitBtn = $(this).find('button[type="submit"]');
            const originalContent = submitBtn.html();

            // تغيير حالة الزر إلى حالة التحميل
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Adding...').prop('disabled', true);

            $.ajax({
                url: '/subject',
                type: 'POST',
                data: {
                    name: $('#addName').val(),
                    success_mark: $('#addSuccessMark').val(),
                    full_mark: $('#addFullMark').val(),

                },
                success: function(response) {
                    if (response.success) {
                        // تحديث الجدول
                        fetchSubjects();

                        // إغلاق النافذة المنبثقة
                        closeAddModal();

                        // إظهار رسالة نجاح
                        showAlert('Subject added successfully', 'success');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    if (response.errors) {
                        displayAddSubjectErrors(response.errors);
                    } else {
                        displayAddSubjectErrors('An error occurred while adding the subject');
                    }
                },
                complete: function() {
                    // إعادة الزر إلى حالته الأصلية
                    submitBtn.html(originalContent).prop('disabled', false);
                }
            });
        });

        // التحقق من المدخلات أثناء الكتابة
        $('#addName, #addSuccessMark, #addFullMark').on('input', function() {
            const field = $(this).attr('id').replace('add', '').toLowerCase();
            const errorSpan = $(`#addForm .error-message[data-for="${field}"]`);

            // إخفاء رسالة الخطأ عند الكتابة
            errorSpan.addClass('hidden');
            $(this).removeClass('border-red-500');
        });

        // دالة إعادة تعيين أخطاء نموذج التعديل
        function resetEditSubjectErrors() {
            $('#editSubjectErrors').addClass('hidden').find('ul').empty();
            $('#editForm .error-message').addClass('hidden').text('');
            $('#editForm input').removeClass('border-red-500');
        }

        // دالة عرض أخطاء نموذج التعديل
        function displayEditSubjectErrors(errors) {
            const errorContainer = $('#editSubjectErrors');
            const errorList = errorContainer.find('ul');
            errorList.empty();

            if (typeof errors === 'string') {
                errorList.append(`<li>${errors}</li>`);
                errorContainer.removeClass('hidden');
                return;
            }

            Object.keys(errors).forEach(field => {
                const errorMsg = errors[field][0];
                errorList.append(`<li>${errorMsg}</li>`);

                const errorSpan = $(`#editForm .error-message[data-for="${field}"]`);
                if (errorSpan.length) {
                    errorSpan.removeClass('hidden').text(errorMsg);
                    $(`#edit${field.charAt(0).toUpperCase() + field.slice(1)}`).addClass('border-red-500');
                }
            });

            errorContainer.removeClass('hidden');
        }

        function openEditModal(subject) {
            resetEditSubjectErrors();

            $('#editSubjectId').val(subject.id);
            $('#editName').val(subject.name.trim());
            $('#editSuccessMark').val(subject.success_mark);
            $('#editFullMark').val(subject.full_mark);

            $('#editModal').removeClass('hidden');
        }

        function closeEditModal() {
            $('#editModal').addClass('hidden');
            resetEditSubjectErrors();
            $('#editForm')[0].reset();
        }

        // معالجة تقديم نموذج التعديل
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            resetEditSubjectErrors();

            const subjectId = $('#editSubjectId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalContent = submitBtn.html();

            // تغيير حالة الزر إلى حالة التحميل
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...').prop('disabled', true);

            $.ajax({
                url: `/subject/${subjectId}`,
                type: 'PUT',
                data: {
                    name: $('#editName').val(),
                    success_mark: $('#editSuccessMark').val(),
                    full_mark: $('#editFullMark').val(),

                },
                success: function(response) {
                    if (response.success) {
                        // تحديث الصف في الجدول مباشرة
                        const row = $(`tr[data-subject-id="${subjectId}"]`);
                        row.find('.subject-name').text(response.subject.name);
                        row.find('.subject-mark').text(response.subject.mark);

                        // إغلاق النافذة المنبثقة
                        closeEditModal();

                        // إظهار رسالة نجاح
                        showAlert('Subject updated successfully', 'success');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    if (response.errors) {
                        displayEditSubjectErrors(response.errors);
                    } else if (response.message) {
                        displayEditSubjectErrors(response.message);
                    } else {
                        displayEditSubjectErrors('An error occurred while updating the subject');
                    }
                },
                complete: function() {
                    // إعادة الزر إلى حالته الأصلية
                    submitBtn.html(originalContent).prop('disabled', false);
                }
            });
        });

        // التحقق من المدخلات أثناء الكتابة
        $('#editName,#editSuccessMark, #editFullMark').on('input', function() {
            const field = $(this).attr('id').replace('edit', '').toLowerCase();
            const errorSpan = $(`#editForm .error-message[data-for="${field}"]`);

            // إخفاء رسالة الخطأ عند الكتابة
            errorSpan.addClass('hidden');
            $(this).removeClass('border-red-500');
        });

        function showSubjectUsers(subjectId, page = 1) {
            currentSubjectId = subjectId;
            $('#usersModal').removeClass('hidden');
            // showLoading();

            fetchSubjectUsers(subjectId, page);
        }
        let searchTimer;

        $('#userSearchInput').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => fetchSubjectUsers(currentSubjectId), 300);
        });

        function fetchSubjectUsers(subjectId, page = 1) {
            const searchTerm = $('#userSearchInput').val();

            showLoading();
            $('#subjectUsersTableBody').empty();
            $('#subjectUsersPagination').empty();

            $.ajax({
                url: `/subject/${subjectId}/users`,
                type: 'GET',
                data: {
                    page: page,
                    search: searchTerm
                },
                success: function(response) {
                    if (response.success) {
                        renderSubjectUsers(response.data.users);

                        if (response.data.pagination) {
                            $('#subjectUsersPagination').html(response.data.pagination);

                            // تحسين طريقة الحصول على رقم الصفحة
                            $('#subjectUsersPagination').find('a').on('click', function(e) {
                                e.preventDefault();
                                const href = $(this).attr('href');
                                const pageNum = href ? new URLSearchParams(href.split('?')[1]).get(
                                    'page') : 1;

                                if (pageNum) {
                                    fetchSubjectUsers(subjectId, parseInt(pageNum));
                                }
                            });
                        }
                    } else {
                        showAlert(response.message || 'Failed to load users', 'error');
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Error loading users';
                    showAlert(errorMessage, 'error');

                    $('#subjectUsersTableBody').html(`
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-white">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <i class="fas fa-exclamation-circle text-4xl text-red-400"></i>
                            <p class="text-white text-opacity-60">${errorMessage}</p>
                        </div>
                    </td>
                </tr>
            `);
                },
                complete: function() {
                    hideLoading();
                }
            });
        }
        // دالة مساعدة لعرض حالة التحميل
        function showLoading() {
            $('#subjectUsersTableBody').html(`
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-white">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <i class="fas fa-spinner fa-spin text-4xl text-white text-opacity-40"></i>
                            <p class="text-white text-opacity-60">Loading users...</p>
                        </div>
                    </td>
                </tr>
            `);
        }

        // دالة مساعدة لإخفاء حالة التحميل
        function hideLoading() {
            // يتم التعامل مع هذا تلقائ��
        }

        function renderSubjectUsers(users) {
            const tbody = $('#subjectUsersTableBody');
            tbody.empty();

            users.forEach(user => {
                tbody.append(`
                    <tr class="hover:bg-white hover:bg-opacity-5" id="userId_${user.id}" >
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">${user.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">${user.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white" id="userMark_${user.id}" >${user.pivot.mark}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            <div class="flex space-x-2">
                                <button onclick="editUserMark(${user.id}, '${user.name}', ${user.pivot.mark})"
                                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Edit Mark
                                </button>
                                <button onclick="removeUserFromSubject(${user.id}, '${user.name}')"
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Remove
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
        }

        function renderSubjectUsersPagination(usersData) {
            const paginationContainer = $('#subjectUsersPagination');
            paginationContainer.empty();

            if (usersData.total <= usersData.per_page) return;

            let paginationHtml =
                '<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">';

            // Previous page link
            paginationHtml += `
                <div class="flex justify-between flex-1 sm:hidden">
                    <button onclick="fetchSubjectUsers(${currentSubjectId}, ${usersData.current_page - 1})"
                        class="${usersData.current_page === 1 ? 'cursor-not-allowed opacity-50' : ''} relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-white bg-opacity-10 border border-white border-opacity-20 rounded-md hover:bg-white hover:bg-opacity-20"
                        ${usersData.current_page === 1 ? 'disabled' : ''}>
                        Previous
                    </button>
                    <button onclick="fetchSubjectUsers(${currentSubjectId}, ${usersData.current_page + 1})"
                        class="${usersData.current_page === usersData.last_page ? 'cursor-not-allowed opacity-50' : ''} relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-white bg-opacity-10 border border-white border-opacity-20 rounded-md hover:bg-white hover:bg-opacity-20"
                        ${usersData.current_page === usersData.last_page ? 'disabled' : ''}>
                        Next
                    </button>
                </div>`;

            // Desktop pagination
            paginationHtml += `
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-white">
                            Showing
                            <span class="font-medium">${(usersData.current_page - 1) * usersData.per_page + 1}</span>
                            to
                            <span class="font-medium">${Math.min(usersData.current_page * usersData.per_page, usersData.total)}</span>
                            of
                            <span class="font-medium">${usersData.total}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">`;

            // Previous page button
            paginationHtml += `
                <button onclick="fetchSubjectUsers(${currentSubjectId}, ${usersData.current_page - 1})"
                    class="${usersData.current_page === 1 ? 'cursor-not-allowed opacity-50' : ''} relative inline-flex items-center px-2 py-2 rounded-l-md border border-white border-opacity-20 bg-white bg-opacity-10 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20"
                    ${usersData.current_page === 1 ? 'disabled' : ''}>
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>`;

            // Page numbers
            for (let i = 1; i <= usersData.last_page; i++) {
                if (
                    i === 1 ||
                    i === usersData.last_page ||
                    (i >= usersData.current_page - 2 && i <= usersData.current_page + 2)
                ) {
                    paginationHtml += `
                        <button onclick="fetchSubjectUsers(${currentSubjectId}, ${i})"
                            class="relative inline-flex items-center px-4 py-2 border border-white border-opacity-20 ${
                                i === usersData.current_page
                                    ? 'bg-white bg-opacity-20 text-white'
                                    : 'bg-white bg-opacity-10 text-white hover:bg-white hover:bg-opacity-20'
                            } text-sm font-medium">
                            ${i}
                        </button>`;
                } else if (
                    i === usersData.current_page - 3 ||
                    i === usersData.current_page + 3
                ) {
                    paginationHtml += `
                        <span class="relative inline-flex items-center px-4 py-2 border border-white border-opacity-20 bg-white bg-opacity-10 text-white text-sm font-medium">
                            ...
                        </span>`;
                }
            }

            // Next page button
            paginationHtml += `
                <button onclick="fetchSubjectUsers(${currentSubjectId}, ${usersData.current_page + 1})"
                    class="${usersData.current_page === usersData.last_page ? 'cursor-not-allowed opacity-50' : ''} relative inline-flex items-center px-2 py-2 rounded-r-md border border-white border-opacity-20 bg-white bg-opacity-10 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20"
                    ${usersData.current_page === usersData.last_page ? 'disabled' : ''}>
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>`;

            paginationHtml += `
                    </span>
                </div>
            </div>
        </nav>`;

            paginationContainer.html(paginationHtml);
        }

        function closeUsersModal() {
            $('#usersModal').addClass('hidden');
            $('#subjectUsersTableBody').empty();
            $('#subjectUsersPagination').empty();
            $('#userSearchInput').val('');
            currentSubjectId = null;
        }

        function editUserMark(userId, userName, currentMark) {
            $('#editMarkUserId').val(userId);
            $('#editMarkUserName').text(userName);
            $('#editMarkValue').val(currentMark || '');
            $('#editMarkModal').removeClass('hidden');
        }

        function closeEditMarkModal() {
            $('#editMarkModal').addClass('hidden');
            $('#editMarkForm')[0].reset();
            $('.error-message').addClass('hidden');
        }

        $('#editMarkForm').on('submit', function(e) {
            e.preventDefault();
            const userId = $('#editMarkUserId').val();
            const mark = $('#editMarkValue').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalContent = submitBtn.html();

            // التحقق من صحة القيمة
            if (mark === '' || isNaN(mark) || mark < 0 || mark > 100) {
                $('.error-message[data-for="mark"]')
                    .text('Please enter a valid mark between 0 and 100')
                    .removeClass('hidden');
                return;
            }

            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...').prop('disabled', true);

            $.ajax({
                url: `/admin/subject/${currentSubjectId}/users/${userId}/mark`,
                type: 'PUT',
                data: { mark: mark },
                success: function(response) {
                    if (response.success) {
                        closeEditMarkModal();
                        showAlert('Mark updated successfully', 'success');
                         $('#userMark_' + userId).text(mark);

                        refreshUsersList();
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    if (response.errors) {
                        Object.keys(response.errors).forEach(key => {
                            $('.error-message[data-for="mark"]')
                                .text(response.errors[key][0])
                                .removeClass('hidden');
                        });
                    }
                },
                complete: function() {
                    submitBtn.html(originalContent).prop('disabled', false);
                }
            });
        });

        // إضافة مستمع للإدخال لإخفاء رسالة الخطأ عند الكتابة
        $('#editMarkValue').on('input', function() {
            $('.error-message[data-for="mark"]').addClass('hidden');
        });

        function removeUserFromSubject(userId, userName) {
            $('#removeUserModal').removeClass('hidden');
            $('#removeUserName').text(userName);
            $('#removeUserId').val(userId);
        }

        function confirmRemoveUser() {
            const userId = $('#removeUserId').val();
            const submitBtn = $('#confirmRemoveBtn');
            const originalContent = submitBtn.html();

            submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Removing...').prop('disabled', true);

            $.ajax({
                url: `/admin/subject/${currentSubjectId}/users/${userId}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        closeRemoveUserModal();
                        showAlert('User removed successfully', 'success');
                        $('#userId_' + userId).remove();

                        refreshUsersList();
                    } else {
                        showAlert('Error removing user', 'error');
                    }
                },
                error: function() {
                    showAlert('Error removing user', 'error');
                },
                complete: function() {
                    submitBtn.html(originalContent).prop('disabled', false);
                }
            });
        }

        function refreshUsersList() {
            const searchTerm = $('#searchInput').val();
            // loadUsers(searchTerm);
        }


        function closeEditMarkModal() {
            $('#editMarkModal').addClass('hidden');
            editMarkUserId = null;
            $('#editMarkForm')[0].reset();
            $('.error-message').addClass('hidden');
        }


        function openRemoveUserModal(userId, userName) {
            removeUserId = userId;
            $('#removeUserName').text(userName);
            $('#removeUserModal').removeClass('hidden');
        }

        function closeRemoveUserModal() {
            $('#removeUserModal').addClass('hidden');
            $('#removeUserId').val('');
        }
    </script>
@endsection("script")

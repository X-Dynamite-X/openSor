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
                                    Mark</th>


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
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Add New Subject</h3>

                <!-- Error Container -->
                <div id="addSubjectErrors" class="hidden mb-4 p-4 rounded-lg bg-red-500 bg-opacity-20 border border-red-500 text-red-100">
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
                        <label class="block text-white text-sm font-medium mb-2">Mark</label>
                        <input type="number" id="addMark" required min="0" max="100"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="mark"></span>
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
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white bg-opacity-10 backdrop-blur-lg border-white border-opacity-20">
            <div class="mt-3">
                <h3 class="text-xl font-bold text-white mb-4">Edit Subject</h3>

                <!-- Error Container -->
                <div id="editSubjectErrors" class="hidden mb-4 p-4 rounded-lg bg-red-500 bg-opacity-20 border border-red-500 text-red-100">
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
                        <label class="block text-white text-sm font-medium mb-2">Mark</label>
                        <input type="number" id="editMark"
                            class="w-full px-4 py-2 rounded-lg border border-white border-opacity-20 bg-white bg-opacity-10 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <!-- Field Error Message -->
                        <span class="error-message text-red-400 text-xs mt-1 hidden" data-for="mark"></span>
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
            $('#editMark').val(subject.mark);
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
                    mark: $('#editMark').val(),
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
                    mark: $('#addMark').val(),
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
        $('#addName, #addMark').on('input', function() {
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
            $('#editMark').val(subject.mark);
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
                    mark: $('#editMark').val(),
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
        $('#editName, #editMark').on('input', function() {
            const field = $(this).attr('id').replace('edit', '').toLowerCase();
            const errorSpan = $(`#editForm .error-message[data-for="${field}"]`);

            // إخفاء رسالة الخطأ عند الكتابة
            errorSpan.addClass('hidden');
            $(this).removeClass('border-red-500');
        });
    </script>
@endsection("script")

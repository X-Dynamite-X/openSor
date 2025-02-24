<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class= " dark:bg-gradient-to-br from-blue-800 via-cyan-600  to-cyan-800 min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo Container -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-4xl font-bold text-white mb-2">Reset Password</h2>
                <p class="text-white/80">Enter your new password</p>
            </div>

            <!-- Reset Password Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <form id="resetPasswordForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ request()->email }}">

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                New Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" required
                                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg
                                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                    dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg
                                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                    dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="••••••••">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePasswordConfirmation" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div id="errorMessage" class="hidden">
                            <div class="text-red-500 text-sm flex items-start">
                                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                <span class="error-text"></span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg
                            shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function togglePasswordVisibility(inputId, buttonId) {
                $(buttonId).on('click', function() {
                    const input = $(inputId);
                    const icon = $(this).find('i');

                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            }

            togglePasswordVisibility('#password', '#togglePassword');
            togglePasswordVisibility('#password_confirmation', '#togglePasswordConfirmation');

            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault();

                const submitButton = $(this).find('button[type="submit"]');
                const originalContent = submitButton.html();
                submitButton.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

                $.ajax({
                    url: '{{ route("password.update") }}',
                    type: 'POST',
                    data: {
                        token: $('input[name="token"]').val(),
                        email: $('input[name="email"]').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            submitButton.html('<i class="fas fa-check"></i>');
                            // عرض رسالة النجاح
                            alert(response.message);
                            // إعادة التوجيه إلى صفحة تسجيل الدخول
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        $('#errorMessage')
                            .removeClass('hidden')
                            .find('.error-text')
                            .text(response.message || 'An error occurred');

                        submitButton.html(originalContent).prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>

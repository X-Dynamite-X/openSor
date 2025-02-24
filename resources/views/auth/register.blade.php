<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register - {{ config('app.name') }}</title>

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
                <h2 class="text-4xl font-bold text-white mb-2">Create Account</h2>
                <p class="text-white/80">Join our community today</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <form id="registerForm" class="space-y-6">
                        @csrf

                        <!-- Full Name Fields -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div class="space-y-2">
                                <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    First Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input id="firstName" name="first_name" type="text" required
                                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg
                                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                        dark:bg-gray-700 dark:text-white text-sm"
                                        placeholder="John">
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="space-y-2">
                                <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Last Name
                                </label>
                                <div class="relative">
                                    <input id="lastName" name="last_name" type="text" required
                                        class="block w-full pl-3 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg
                                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                        dark:bg-gray-700 dark:text-white text-sm"
                                        placeholder="Doe">
                                </div>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" required
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg
                                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                    dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="your@email.com">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
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
                            <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="passwordConfirmation" name="password_confirmation" type="password" required
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

                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3">
                                <label for="terms" class="text-sm text-gray-700 dark:text-gray-300">
                                    I agree to the
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms of Service</a>
                                    and
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg
                                text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                transition duration-150 ease-in-out">
                                <span class="flex items-center">
                                    <span class="mr-2">Create Account</span>
                                    <i class="fas fa-user-plus"></i>
                                </span>
                            </button>
                        </div>

                        <!-- Error Message -->
                        <div id="errorMessage" class="hidden">
                            <div class="bg-red-50 dark:bg-red-900/50 text-red-500 dark:text-red-400 p-3 rounded-lg text-sm">
                                <div class="flex">
                                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                    <span class="error-text"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>

            <!-- Social Register -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-white bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
                            Or register with
                        </span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3">
                    <button class="w-full inline-flex justify-center py-2 px-4 border border-white/20 rounded-lg
                        bg-white/10 hover:bg-white/20 text-white transition duration-150 ease-in-out">
                        <i class="fab fa-google"></i>
                    </button>
                    <button class="w-full inline-flex justify-center py-2 px-4 border border-white/20 rounded-lg
                        bg-white/10 hover:bg-white/20 text-white transition duration-150 ease-in-out">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="w-full inline-flex justify-center py-2 px-4 border border-white/20 rounded-lg
                        bg-white/10 hover:bg-white/20 text-white transition duration-150 ease-in-out">
                        <i class="fab fa-github"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle Password Visibility
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
            togglePasswordVisibility('#passwordConfirmation', '#togglePasswordConfirmation');

            // Form Submission
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Add loading state to button
                const submitButton = $(this).find('button[type="submit"]');
                const originalContent = submitButton.html();
                submitButton.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

                // Validate passwords match
                const password = $('#password').val();
                const passwordConfirmation = $('#passwordConfirmation').val();

                if (password !== passwordConfirmation) {
                    $('#errorMessage')
                        .removeClass('hidden')
                        .find('.error-text')
                        .text('Passwords do not match');
                    submitButton.html(originalContent).prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '{{ route("register") }}',
                    type: 'POST',
                    data: {
                        first_name: $('#firstName').val(),
                        last_name: $('#lastName').val(),
                        email: $('#email').val(),
                        password: password,
                        password_confirmation: passwordConfirmation,
                        terms: $('#terms').is(':checked'),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add success animation before redirect
                            submitButton.html('<i class="fas fa-check"></i>');
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        $('#errorMessage')
                            .removeClass('hidden')
                            .find('.error-text')
                            .text(response.message || 'An error occurred');

                        // Shake animation for error
                        $('#errorMessage').addClass('animate-shake');
                        setTimeout(() => {
                            $('#errorMessage').removeClass('animate-shake');
                        }, 500);

                        // Reset button
                        submitButton.html(originalContent).prop('disabled', false);
                    }
                });
            });
        });
    </script>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
    </style>
</body>
</html>

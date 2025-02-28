@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden max-w-2xl w-full">
            <div class="p-8 text-center">
                <!-- Warning Icon -->
                <div class="mx-auto w-24 h-24 flex items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900 mb-6">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <!-- Message Title -->
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Account Not Active
                </h2>

                <!-- Message Content -->
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    Please wait until your account is activated by the administrator.
                    You will be notified once your account is ready to use.
                </p>

                <!-- Additional Information -->
                <div class="bg-blue-50 dark:bg-blue-900/50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        If you have any questions, please contact our support team.
                    </p>
                </div>

                <!-- Return Home Button -->
                <a href="{{ route('login') }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Return Login
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

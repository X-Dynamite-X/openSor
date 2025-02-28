@extends('layouts.app')

@section('content')
<div class="min-h-screen   py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Student Profile Header -->
        <div class="bg-gray-800 rounded-lg shadow-xl p-6 mb-8">
            <div class="flex items-center space-x-6">
                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-600">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                         alt="Profile" class="h-full w-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-400">{{ Auth::user()->email }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ Auth::user()->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Progress -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Overall Statistics -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Overall Progress</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm text-gray-400 mb-1">
                            <span>Average Score</span>
                            <span>{{ number_format(auth()->user()->subjects->avg('pivot.mark'), 1) }}%</span>
                        </div>
                        <div class="h-2 bg-gray-700 rounded-full">
                            <div class="h-2 bg-blue-500 rounded-full"
                                 style="width: {{ auth()->user()->subjects->avg('pivot.mark') }}%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-gray-700 rounded-lg p-3">
                            <p class="text-gray-400 text-sm">Total Subjects</p>
                            <p class="text-white text-xl font-bold">{{ auth()->user()->subjects->count() }}</p>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-3">
                            <p class="text-gray-400 text-sm">Passed Subjects</p>
                            <p class="text-white text-xl font-bold">
                                {{ auth()->user()->subjects->where('pivot.mark', '>=', 'success_mark')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="md:col-span-2 bg-gray-800 rounded-lg shadow-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Subject Marks</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-gray-400 text-left text-sm">
                                <th class="pb-3">Subject</th>
                                <th class="pb-3">Mark</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            @foreach(auth()->user()->subjects as $subject)
                            <tr class="border-t border-gray-700">
                                <td class="py-3">{{ $subject->name }}</td>
                                <td class="py-3">{{ $subject->pivot->mark ?? 'N/A' }}/{{ $subject->full_mark }}</td>
                                <td class="py-3">
                                    @if(isset($subject->pivot->mark))
                                        @if($subject->pivot->mark >= $subject->success_mark)
                                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Passed</span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Failed</span>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-800">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $subject->pivot->mark >= $subject->success_mark ? 'bg-green-500' : 'bg-blue-500' }}"
                                             style="width: {{ ($subject->pivot->mark / $subject->full_mark) * 100 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Latest Announcements -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Important Information</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-500">
                                <i class="fas fa-info-circle text-white"></i>
                            </span>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Success Mark Requirements</h3>
                            <p class="text-gray-400 text-sm">
                                You need to achieve at least the success mark in each subject to pass.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-500">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </span>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Academic Support</h3>
                            <p class="text-gray-400 text-sm">
                                Contact your instructors for additional help and resources.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg p-4 transition duration-200">
                        <i class="fas fa-comments"></i>
                        <span>Chat with Teachers</span>
                    </button>
                    <button class="flex items-center justify-center space-x-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg p-4 transition duration-200">
                        <i class="fas fa-calendar-alt"></i>
                        <span>View Schedule</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Add any JavaScript functionality here
</script>
@endsection

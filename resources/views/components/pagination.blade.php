@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-6" aria-label="Pagination">
        <ul class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 rounded-lg bg-white bg-opacity-10 text-white text-opacity-40 cursor-not-allowed">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </span>
                </li>
            @else
                <li>
                    <button onclick="fetchAvailableUsers({{ $paginator->currentPage() - 1 }})"
                       class="px-3 py-2 rounded-lg bg-white bg-opacity-10 text-white hover:bg-opacity-20 transition duration-150 ease-in-out">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                </li>
            @endif

            {{-- Pagination Numbers --}}
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($start + 4, $paginator->lastPage());
                if ($end - $start < 4) {
                    $start = max($end - 4, 1);
                }
            @endphp

            @if($start > 1)
                <li>
                    <button onclick="fetchAvailableUsers(1)"
                       class="px-4 py-2 rounded-lg bg-white bg-opacity-10 text-white hover:bg-opacity-20 transition duration-150 ease-in-out">
                        1
                    </button>
                </li>
                @if($start > 2)
                    <li>
                        <span class="px-2 text-white text-opacity-40">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <li>
                    <button onclick="fetchAvailableUsers({{ $i }})"
                       class="px-4 py-2 rounded-lg {{ $i == $paginator->currentPage()
                            ? 'bg-purple-500 text-white'
                            : 'bg-white bg-opacity-10 text-white hover:bg-opacity-20' }}
                            transition duration-150 ease-in-out">
                        {{ $i }}
                    </button>
                </li>
            @endfor

            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <li>
                        <span class="px-2 text-white text-opacity-40">...</span>
                    </li>
                @endif
                <li>
                    <button onclick="fetchAvailableUsers({{ $paginator->lastPage() }})"
                       class="px-4 py-2 rounded-lg bg-white bg-opacity-10 text-white hover:bg-opacity-20 transition duration-150 ease-in-out">
                        {{ $paginator->lastPage() }}
                    </button>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button onclick="fetchAvailableUsers({{ $paginator->currentPage() + 1 }})"
                       class="px-3 py-2 rounded-lg bg-white bg-opacity-10 text-white hover:bg-opacity-20 transition duration-150 ease-in-out">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 rounded-lg bg-white bg-opacity-10 text-white text-opacity-40 cursor-not-allowed">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

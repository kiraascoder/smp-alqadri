@props(['route', 'label', 'icon'])

<a href="{{ $route }}"
    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-blue-800 transition text-blue-100 hover:text-white">
    {{-- Ikon inline pakai Heroicons --}}
    @switch($icon)
        @case('chart-bar')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M9 17v-6m4 6V9m4 6v-3" />
            </svg>
        @break

        @case('users')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20v-2a4 4 0 00-3-3.87M9 20v-2a4 4 0 013-3.87M12 4a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
        @break

        @case('user-group')
        @case('user')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M12 14a4 4 0 100-8 4 4 0 000 8z" />
            </svg>
        @break

        @case('exclamation-circle')
        @case('exclamation')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-4.6 11.1A6.5 6.5 0 0112 5.5z" />
            </svg>
        @break

        @case('clock')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6l4 2M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
        @break

        @case('academic-cap')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 14l9-5-9-5-9 5 9 5zM12 14v6m0 0l-3-2m3 2l3-2" />
            </svg>
        @break

        @case('ban')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.364 5.636a9 9 0 11-12.728 0m12.728 0L5.636 18.364" />
            </svg>
        @break

        @case('inbox')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0l-4 4H8l-4-4m16 0H4" />
            </svg>
        @break

        @case('chat-alt')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.84L3 20l1.6-3.2A7.97 7.97 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        @break

        @case('document-report')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2M9 7h.01M12 7h.01M15 7h.01M9 10h6M12 21a9 9 0 100-18 9 9 0 000 18z" />
            </svg>
        @break
    @endswitch

    {{ $label }}
</a>

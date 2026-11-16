@php
    $children = $positions->where('parent_id', $node->id);
@endphp
<li class="org-item">
    <article class="org-card rounded-2xl border border-emerald-100 bg-white shadow-sm overflow-hidden mx-auto">
        <div class="bg-emerald-800 text-white py-3 px-4 text-center font-bold text-sm tracking-wide">{{ $node->title }}</div>
        @if($node->members->isNotEmpty())
            <div class="p-3 space-y-3">
                @foreach($node->members as $person)
                    <div class="flex flex-col items-center text-center gap-1">
                        @if($person->photo_path)
                            <img src="{{ asset('storage/'.$person->photo_path) }}" alt="Foto {{ $person->name }}" loading="lazy" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-100">
                        @endif
                        <div class="font-semibold text-slate-800 text-sm">{{ $person->name }}</div>
                        @if($person->subtitle)<div class="text-xs text-slate-500">{{ $person->subtitle }}</div>@endif
                    </div>
                @endforeach
            </div>
        @endif
    </article>
    @if($children->isNotEmpty())
        <ul class="org-children {{ $children->count() > 6 ? 'org-grid-children' : '' }}">
            @foreach($children as $child)
                @include('struktur._node', ['node' => $child, 'positions' => $positions])
            @endforeach
        </ul>
    @endif
</li>

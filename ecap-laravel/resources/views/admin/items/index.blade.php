@extends('layouts.app')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
    <div class="topic">
        <h2>Item List</h2>
        <div class="topic-discription">
            <p>List of all items available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()" aria-label="Search items">
                <select id="typeFilter" onchange="filterTable()" aria-label="Filter by type">
                    <option value="">All Types</option>
                    @foreach($types as $t)
                        <option value="{{ $t->name }}">{{ $t->name }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.items.create') }}" class="dash-btn">Add Item</a>
            </div>
        </div>
    </div>
    <div class="table-container">

        @if($items->isNotEmpty())
            <div id="itemTable">
                @foreach($items as $item)
                    <div class="card-row" data-name="{{ strtolower($item->name) }}" data-type="{{ strtolower($item->itemType->name ?? '') }}">
                        @php
                            $raw = $item->images->first()->image ?? null;
                            $img = null;
                            if ($raw) {
                                $img = preg_replace('#^\.\/#','/', $raw);
                                if (!preg_match('#^(/|https?://)#', $img)) {
                                    $img = '/' . ltrim($img, '/');
                                }
                                if (!file_exists(public_path(ltrim($img, '/')))) {
                                    $img = null;
                                }
                            }
                            $img = $img ?? '/images/products/logo.png';
                        @endphp
                        <div class="card-image">
                            <a href="{{ route('item.show', $item->getKey()) }}">
                                <img src="{{ $img }}" alt="{{ $item->name }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-title">{{ $item->name }}</div>
                            <div class="card-sub">{{ $item->short_dis }}</div>
                            <div class="card-meta">
                                <div class="meta-type">{{ $item->itemType->name ?? 'N/A' }}</div>
                                <div class="meta-price">LKR {{ number_format($item->price,2) }}</div>
                            </div>
                        </div>
                        <div class="actions">
                            <a class="btn btn-primary" href="{{ route('admin.items.edit', $item->getKey()) }}">Edit</a>
                            <form action="{{ route('admin.items.toggle', $item->getKey()) }}" method="POST" style="display:inline;">
                                @csrf
                                <a href="#" class="btn {{ $item->inactive_status == 0 ? 'toggle-enabled' : 'toggle-disabled' }} js-submit" role="button" data-confirm="{{ $item->inactive_status == 0 ? 'Disable this item?' : 'Enable this item?' }}">{{ $item->inactive_status == 0 ? 'Enabled' : 'Disabled' }}</a>
                                <button type="submit" style="display:none" aria-hidden="true"></button>
                            </form>
                            <form action="{{ route('admin.items.destroy', $item->getKey()) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-danger js-submit" role="button" data-confirm="Remove this item?">Remove</a>
                                <button type="submit" style="display:none" aria-hidden="true"></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No results found.</p>
        @endif
    </div>
    </main>

@endsection

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
        const table = document.getElementById('itemTable');
        if(!table) return;
        const rows = table.getElementsByClassName('card-row');

        Array.from(rows).forEach(row => {
            const nameText = (row.getAttribute('data-name') || '').toLowerCase();
            const typeText = (row.getAttribute('data-type') || '').toLowerCase();
            if ((nameText.includes(searchInput) || searchInput === '') && (typeText === typeFilter || typeFilter === '')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@push('scripts')
            <script>
                // legacy inline fallback removed — centralised in /js/adm/admin-actions.js
            </script>
@endpush

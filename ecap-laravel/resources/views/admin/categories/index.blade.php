@extends('layouts.app')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
    <div class="topic">
        <h2>Category List</h2>
        <div class="topic-discription">
            <p>List of all categories available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()" aria-label="Search categories">
                <a href="{{ route('admin.categories.create') }}" class="dash-btn">Add Category</a>
            </div>
        </div>
    </div>
    <div class="table-container">

        @if(session('error'))
            <div class="success-message" style="background:#fff4e5;color:#663c00;border:1px solid #f6c37d;padding:10px;margin-bottom:12px;">
                <strong>Error:</strong> {{ session('error') }}
                @if(session('error_items') && is_array(session('error_items')))
                    <div style="margin-top:8px;font-size:0.95rem">
                        <div>Items in this category (click to edit):</div>
                        <ul style="margin:6px 0;padding-left:18px">
                            @foreach(session('error_items') as $it)
                                <li><a href="{{ $it['url'] }}">{{ $it['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif


        @php $types = \App\Models\ItemType::orderBy('name')->get(); @endphp

        @if($types->isNotEmpty())
            <div id="itemTable">
                @foreach($types as $type)
                    <div class="card-row" data-name="{{ strtolower($type->name) }}">
                        <div class="card-body">
                            <div class="card-title">{{ $type->name }}</div>
                            <div class="card-sub">{{ $type->short_discription }}</div>
                            <div class="card-sub" style="margin-top:6px">{{ Str::limit($type->discription, 180) }}</div>
                        </div>
                        <div class="actions">
                            <a class="btn btn-primary" href="{{ route('admin.categories.edit', $type->no) }}">Edit</a>
                            <form action="{{ route('admin.categories.toggle', $type->no) }}" method="POST" style="display:inline;">
                                @csrf
                                <a href="#" class="btn {{ $type->inactive_status == 0 ? 'toggle-enabled' : 'toggle-disabled' }} js-submit" role="button" data-confirm="{{ $type->inactive_status == 0 ? 'Disable this category?' : 'Enable this category?' }}">{{ $type->inactive_status == 0 ? 'Enabled' : 'Disabled' }}</a>
                                <button type="submit" style="display:none" aria-hidden="true"></button>
                            </form>
                            <form action="{{ route('admin.categories.destroy', $type->no) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-danger js-submit" role="button" data-confirm="Remove this category?">Remove</a>
                                <button type="submit" style="display:none" aria-hidden="true"></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No categories found.</p>
        @endif
    </div>
    </main>

@endsection

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('itemTable');
        if(!table) return;
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[0];

            if (nameCell) {
                const nameText = nameCell.textContent.toLowerCase();

                if (nameText.includes(searchInput) || searchInput === '') {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
@push('scripts')
    <script>
        // Handled by /js/adm/admin-actions.js (central modal + submit handlers)
    </script>
@endpush

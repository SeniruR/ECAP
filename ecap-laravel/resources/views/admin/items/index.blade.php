@extends('layouts.app')

@section('content')
    @include('admin.dash')

    <main>
    <div class="topic">
        <h2>Item List</h2>
        <div class="topic-discription">
            <p>List of all items available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
                <select id="typeFilter" onchange="filterTable()">
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
        <style>
            table { width:100%; border-collapse: separate; border-spacing:0; margin:20px 0; font-size:16px; text-align:left; border:1px solid #ddd; border-radius:10px; overflow:hidden; }
            table thead tr { background:#f2f2f2; color:#333; }
            table th, table td { padding:12px 15px; border:1px solid #ddd; }
            table tbody tr:nth-child(even){ background:#f9f9f9; }
            table tbody tr:hover{ background:#f1f1f1 }
            .Itemimg img{ border-radius:5px }
            .controls { display:flex; gap:10px }
            .action-buttons{ display:flex; justify-content:center; gap:8px }
        </style>

        @if($items->isNotEmpty())
            <table id="itemTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Short Description</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Actions</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="Itemimg">
                                <a href="{{ route('item.show', $item->no) }}">
                                    @php
                                        $raw = $item->images->first()->image ?? null;
                                        $img = null;
                                        if ($raw) {
                                            // normalize legacy './' paths to absolute '/'
                                            $img = preg_replace('#^\.\/#', '/', $raw);
                                            // if it's a storage URL already (contains /storage/) keep it
                                            if (!preg_match('#^(/|https?://)#', $img)) {
                                                $img = '/' . ltrim($img, '/');
                                            }
                                            // if file doesn't exist in public, fallback later
                                            if (!file_exists(public_path(ltrim($img, '/')))) {
                                                $img = null;
                                            }
                                        }
                                        $img = $img ?? '/images/products/logo.png';
                                    @endphp
                                    <img src="{{ $img }}" alt="Item Image" style="width:100px;height:auto;">
                                </a>
                            </td>
                            <td class="itemName">{{ $item->name }}</td>
                            <td class="itemShortDiscription">{{ $item->short_dis }}</td>
                            <td class="itemType">{{ $item->itemType->name ?? 'N/A' }}</td>
                            <td class="itemPrice">{{ $item->price }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.items.edit', $item->no) }}" class="btn0">Edit</a>
                                    <form action="{{ route('admin.items.toggle', $item->no) }}" method="POST" style="display:inline;margin-left:6px;">
                                        @csrf
                                        <button type="submit" class="{{ $item->inactive_status == 0 ? 'btn1' : 'btn2' }}">{{ $item->inactive_status == 0 ? 'Enabled' : 'Disabled' }}</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="removebtn">
                                    <form action="{{ route('admin.items.destroy', $item->no) }}" method="POST" onsubmit="return confirm('Remove this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">X</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByClassName('itemName')[0];
            const typeCell = rows[i].getElementsByClassName('itemType')[0];

            if (nameCell && typeCell) {
                const nameText = nameCell.textContent.toLowerCase();
                const typeText = typeCell.textContent.toLowerCase();

                if ((nameText.includes(searchInput) || searchInput === '') && (typeText === typeFilter || typeFilter === '')) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>

@extends('layouts.app')

@section('content')
    @include('admin.dash')

    <main>
    <div class="topic">
        <h2>Category List</h2>
        <div class="topic-discription">
            <p>List of all categories available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
                <a href="{{ route('admin.categories.create') }}" class="dash-btn">Add Types</a>
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
            .controls { display:flex; gap:10px }
        </style>

        @php $types = \App\Models\ItemType::orderBy('name')->get(); @endphp

        @if($types->isNotEmpty())
            <table id="itemTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short Description</th>
                        <th>Description</th>
                        <th>Actions</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->short_discription }}</td>
                            <td>{{ $type->discription }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.categories.edit', $type->no) }}" class="btn0">Edit</a>
                                    <form action="{{ route('admin.categories.toggle', $type->no) }}" method="POST" style="display:inline;margin-left:6px;">
                                        @csrf
                                        <button type="submit" class="{{ $type->inactive_status == 0 ? 'btn1' : 'btn2' }}">{{ $type->inactive_status == 0 ? 'Enabled' : 'Disabled' }}</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="removebtn">
                                    <form action="{{ route('admin.categories.destroy', $type->no) }}" method="POST" onsubmit="return confirm('Remove this category?');">
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

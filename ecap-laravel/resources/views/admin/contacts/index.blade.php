@extends('layouts.admin')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <div class="topic">
            <h2>Contact Messages</h2>
            <div class="topic-discription">
                <p>Messages submitted via the contact form.</p>
                <div class="controls">
                    <input type="text" id="searchInput" placeholder="Search by name or email..." onkeyup="filterTable()" aria-label="Search messages">
                </div>
            </div>
        </div>

        <div class="table-container">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            @if($messages->isNotEmpty())
                <div id="itemTable">
                    @foreach($messages as $m)
                        <div class="card-row" data-name="{{ strtolower($m->name) }}" data-email="{{ strtolower($m->email) }}">
                            <div class="card-body">
                                <div class="card-title">{{ $m->name }}</div>
                                <div class="card-sub">{{ $m->subject ?? 'No subject' }}</div>
                                <div class="card-sub" style="margin-top:6px">{{ Str::limit($m->message, 140) }}</div>
                            </div>
                            <div class="meta">
                                <div class="meta-email">{{ $m->email }}</div>
                                <div class="meta-time">{{ $m->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="actions">
                                <a class="btn btn-ghost" href="{{ route('admin.contacts.show', $m) }}">View</a>
                                <form action="{{ route('admin.contacts.destroy', $m) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="btn btn-danger js-submit" role="button" data-confirm="Delete this message?">Delete</a>
                                    <button type="submit" style="display:none" aria-hidden="true"></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">{{ $messages->links() }}</div>
            @else
                <p>No messages found.</p>
            @endif
        </div>
    </main>

@endsection

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('itemTable');
        if(!table) return;
        const rows = table.getElementsByClassName('card-row');

        Array.from(rows).forEach(row => {
            const name = (row.getAttribute('data-name') || '').toLowerCase();
            const email = (row.getAttribute('data-email') || '').toLowerCase();
            if (name.includes(searchInput) || email.includes(searchInput) || searchInput === '') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

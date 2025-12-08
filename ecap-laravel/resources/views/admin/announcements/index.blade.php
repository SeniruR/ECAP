@extends('layouts.app')

@section('content')
    @include('admin.dash')
    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <div class="topic">
            <h2>Announcements</h2>
            <div class="topic-discription">
                <p>Manage site-wide announcements / banners.</p>
                <div class="controls">
                    <input type="text" id="announcementSearch" placeholder="Search by title..." aria-label="Search announcements">
                    <a href="{{ route('admin.announcements.create') }}" class="dash-btn">Add Announcement</a>
                </div>
            </div>
        </div>
        @if(session('status'))<div class="success-message">{{ session('status') }}</div>@endif
        <div style="margin-top:20px">
            @forelse($announcements as $a)
                <div class="card-row">
                    @if(!empty($a->image))
                        <div class="card-image">
                            <img src="{{ $a->image }}" alt="{{ $a->title ?? 'Announcement' }}" loading="lazy">
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="card-title">{{ $a->title ?? 'Untitled' }}</div>
                        <div class="card-sub">{{ Str::limit(strip_tags($a->content), 120) }}</div>
                        <div class="card-meta">{{ $a->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="actions">
                        <a class="btn btn-primary" href="{{ route('admin.announcements.edit', $a->id) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.announcements.toggle', $a->id) }}">@csrf
                            @if($a->is_enabled)
                                <button type="submit" class="toggle-enabled">Disable</button>
                            @else
                                <button type="submit" class="toggle-disabled">Enable</button>
                            @endif
                        </form>
                        <form method="POST" action="{{ route('admin.announcements.destroy', $a->id) }}">@csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No announcements yet.</p>
            @endforelse
        </div>
    </main>
@endsection

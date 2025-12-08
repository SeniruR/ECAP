@extends('layouts.admin')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <div class="topic">
            <h2>Message from {{ $message->name }}</h2>
            <div class="topic-discription">
                <p>Received {{ $message->created_at->toDayDateTimeString() }}</p>
                <div class="controls">
                    <a href="{{ route('admin.contacts.index') }}" class="dash-btn">Back</a>
                </div>
            </div>
        </div>

        <div class="table-container">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="card-title">{{ $message->subject ?? 'No Subject' }}</div>
                    <div class="card-sub">From: <strong>{{ $message->name }}</strong> &middot; {{ $message->email }}</div>
                    <div class="message-body" style="margin-top:12px">{!! nl2br(e($message->message)) !!}</div>
                </div>

                <div class="card-footer">
                    <form method="POST" action="{{ route('admin.contacts.reply', $message) }}">
                        @csrf
                        <div class="form-group">
                            <label for="reply_body">Reply</label>
                            <textarea name="reply_body" id="reply_body" rows="6" class="form-control">{{ old('reply_body', $message->reply_body) }}</textarea>
                            @error('reply_body')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary">Send Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection

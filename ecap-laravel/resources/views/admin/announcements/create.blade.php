@extends('layouts.app')

@section('content')
    @include('admin.dash')
    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <h2>Create Announcement</h2>
        @if($errors->any())
            <div class="success-message" style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:12px;">
                <strong>There were problems with your submission:</strong>
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('status'))<div class="success-message">{{ session('status') }}</div>@endif
        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}">
            </div>
            <div class="form-row">
                <label>Message (HTML allowed)</label>
                <textarea name="content" rows="6">{{ old('content') }}</textarea>
            </div>
            <div class="form-row">
                <label>Image (optional)</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-row">
                <label><input type="checkbox" name="is_enabled"> Enabled</label>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Create</button>
            </div>
        </form>
    </main>
@endsection

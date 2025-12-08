@extends('layouts.app')

@section('content')
    @include('admin.dash')
    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <h2>Edit Announcement</h2>
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
        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-row">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}">
            </div>
            <div class="form-row">
                <label>Message (HTML allowed)</label>
                <textarea name="content" rows="6">{{ old('content', $announcement->content) }}</textarea>
            </div>
            <div class="form-row">
                <label>Image (optional)</label>
                <input type="file" name="image" accept="image/*">
                @if($announcement->image)
                    @php
                        $img = $announcement->image;
                        if ($img && !\Illuminate\Support\Str::startsWith($img, ['http://','https://','/storage/'])) {
                            $img = \Illuminate\Support\Facades\Storage::url($img);
                        }
                    @endphp
                    <div style="margin-top:8px"><img src="{{ $img }}" style="max-width:200px;border-radius:6px;" alt="announcement"></div>
                @endif
            </div>
            <div class="form-row">
                <label><input type="checkbox" name="is_enabled" value="1" @if($announcement->is_enabled) checked @endif> Enabled</label>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </main>
@endsection

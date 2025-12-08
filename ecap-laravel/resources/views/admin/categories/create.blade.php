@extends('layouts.app')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <div>
            <h2 class="mb-2">{{ isset($category) ? 'Edit' : 'Add' }} Category</h2>
            <p class="mb-4">{{ isset($category) ? 'Edit the' : 'Add New' }} category details below.</p>
            @if(session('status'))
                <div class="success-message">{{ session('status') }}</div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="post" novalidate>
                @csrf
                <input type="hidden" name="no" value="{{ $category->no ?? '' }}">
                <div class="form-grid">
                    <div class="form-row">
                        <label for="name">Category Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required aria-required="true">
                    </div>
                    <div class="form-row">
                        <label for="short_description">Short Description</label>
                        <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $category->short_discription ?? '') }}" required>
                    </div>
                    <div class="form-row" style="grid-column:1 / -1">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="5">{{ old('description', $category->discription ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update Category' : 'Add Category' }}</button>
                    <button type="reset" class="btn btn-ghost">Clear</button>
                </div>
            </form>
        </div>
    </main>
@endsection

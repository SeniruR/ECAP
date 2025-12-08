@extends('layouts.app')

@section('content')
    @include('admin.dash')

    @push('styles')
        <link rel="stylesheet" href="/css/adm/admin-modern.css">
    @endpush

    <main class="main-admin">
        <div>
            <h2>{{ isset($item) ? 'Edit' : 'Create' }} Item</h2>
            <p>{{ isset($item) ? 'Modify' : 'Add' }} the details below.</p>
            @if(session('status'))
                <div class="success-message">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="success-message" style="background: #f8d7da; color:#721c24;">
                    <strong>There were some problems with your input:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="no" value="{{ $item->no ?? '' }}">
                <div class="form-grid">
                    <div class="form-row">
                        <label for="item_name">Item Name</label>
                        <input type="text" id="item_name" name="name" value="{{ old('name', $item->name ?? '') }}" required>
                    </div>
                    <div class="form-row">
                        <label for="item_price">Price</label>
                        <input type="number" id="item_price" name="price" step="0.01" value="{{ old('price', $item->price ?? '') }}" required>
                    </div>
                    <div class="form-row">
                        <label for="item_short_description">Short Description</label>
                        <input type="text" id="item_short_description" name="short_dis" value="{{ old('short_dis', $item->short_dis ?? '') }}" required>
                    </div>
                    <div class="form-row">
                        <label for="item_type">Item Type</label>
                        <select id="item_type" name="type" required>
                            <option value="">Select item type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->no }}" @selected((old('type') ?? ($item->type ?? '')) == $type->no)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row" style="grid-column:1 / -1">
                        <label for="item_long_description">Description</label>
                        <textarea id="item_long_description" name="long_dis" rows="4">{{ old('long_dis', $item->long_dis ?? '') }}</textarea>
                    </div>
                    <div class="form-row">
                        <label for="item_contents">Contents</label>
                        <textarea id="item_contents" name="content" rows="3">{{ old('content', $item->content ?? '') }}</textarea>
                    </div>
                    <div class="form-row">
                        <label for="item_benefits">Benefits</label>
                        <textarea id="item_benefits" name="benefits" rows="3">{{ old('benefits', $item->benefits ?? '') }}</textarea>
                    </div>
                    <div class="form-row">
                        <label for="item_trademark">Trademark</label>
                        <input type="text" id="item_trademark" name="trademark" value="{{ old('trademark', $item->trademark ?? '') }}">
                    </div>
                    <div class="form-row">
                        <label for="item_image">Item Image</label>
                        <input type="file" id="item_image" name="images[]" accept="image/*" multiple>
                    </div>
                    <div class="form-row" style="grid-column:1 / -1">
                        <div id="image_preview" style="display:flex;gap:10px;flex-wrap:wrap;">
                            @if(!empty($item->images))
                                @foreach($item->images as $image)
                                    <div style="position:relative;">
                                        <img src="{{ preg_replace('/^\.\//','/', $image->image) }}" style="width:100px;height:100px;object-fit:cover;border:1px solid #ccc;border-radius:5px;" loading="lazy">
                                        <button type="button" class="image-delete" aria-label="Delete image" data-url="{{ route('admin.items.images.destroy', $image->getKey()) }}" style="position:absolute;top:6px;right:6px;background:rgba(0,0,0,0.6);color:#fff;border:none;padding:4px 6px;border-radius:3px;cursor:pointer;">&times;</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="submit">{{ isset($item) ? 'Update Item' : 'Add Item' }}</button>
                    <button type="reset" class="btn btn-ghost">Clear</button>
                </div>
            </form>
        </div>
    </main>
    @push('scripts')
        <script>
            // image-delete behaviour centralised in /js/adm/admin-actions.js
        </script>
    @endpush
@endsection

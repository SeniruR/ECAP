@extends('layouts.app')

@section('content')
    @include('admin.dash')
    @push('styles')
        <link rel="stylesheet" href="/css/adm/add_item.css">
    @endpush

    <main>
        <div class="main_box">
            <div class="rightside">
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
                </div>

                <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="no" value="{{ $item->no ?? '' }}">
                    <table class="table">
                        <tr>
                            <td class="label-cell"><label for="item_name">Item Name</label></td>
                            <td class="input-cell"><input type="text" id="item_name" name="name" value="{{ old('name', $item->name ?? '') }}" required></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_short_description">Short Description</label></td>
                            <td class="input-cell"><textarea id="item_short_description" name="short_dis" rows="2" class="myTextarea" required>{{ old('short_dis', $item->short_dis ?? '') }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_long_description">Description</label></td>
                            <td class="input-cell"><textarea id="item_long_description" name="long_dis" rows="4" class="myTextarea" required>{{ old('long_dis', $item->long_dis ?? '') }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_type">Item Type</label></td>
                            <td class="input-cell">
                                <select id="item_type" name="type" required>
                                    <option value="">Select item type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->no }}" @selected((old('type') ?? ($item->type ?? '')) == $type->no)>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_contents">Contents</label></td>
                            <td class="input-cell"><textarea id="item_contents" name="content" rows="3" class="myTextarea">{{ old('content', $item->content ?? '') }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_benefits">Benefits</label></td>
                            <td class="input-cell"><textarea id="item_benefits" name="benefits" rows="3" class="myTextarea">{{ old('benefits', $item->benefits ?? '') }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_trademark">Trademark</label></td>
                            <td class="input-cell"><input type="text" id="item_trademark" name="trademark" value="{{ old('trademark', $item->trademark ?? '') }}"></td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <div class="trademark">
                                    Gemini™ is a product of Google LLC. (If it's an unregistered trademark) <br>
                                    Gemini® is a registered trademark of Google LLC. (If it's officially registered)
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_price">Price</label></td>
                            <td class="input-cell"><input type="number" id="item_price" name="price" step="0.01" value="{{ old('price', $item->price ?? '') }}" required></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="item_image">Item Image</label></td>
                            <td class="input-cell">
                                <input type="file" id="item_image" name="images[]" accept="image/*" multiple>
                                <div id="image_preview" style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                    @if(!empty($item->images))
                                        @foreach($item->images as $image)
                                            <img src="{{ preg_replace('/^\.\//','/', $image->image) }}" style="width:100px;height:100px;object-fit:cover;border:1px solid #ccc;border-radius:5px;">
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr class="formbutton">
                            <td colspan="2">
                                <div style="text-align:center;">
                                    <button type="submit" name="submit" style="margin-right: 10px;">{{ isset($item) ? 'Update Item' : 'Add Item' }}</button>
                                    <button type="reset">Clear Form</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
@endsection

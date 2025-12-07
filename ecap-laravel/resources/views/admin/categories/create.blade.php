@extends('layouts.app')

@section('content')
    @include('admin.dash')
    <link rel=stylesheet type="text/css" href="/css/adm/add_item.css">
    <main>
        <div class="main_box">
            <div class="rightside">
                <div>
                    <h2>{{ isset($category) ? 'Edit' : 'Add' }} Category</h2>
                    <p>{{ isset($category) ? 'Edit the' : 'Add New' }} category details below.</p>
                    @if(session('status'))
                        <div class="success-message">{{ session('status') }}</div>
                    @endif
                </div>
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="no" value="{{ $category->no ?? '' }}">
                    <table class="table">
                        <tr>
                            <td class="label-cell"><label for="name">Category Name</label></td>
                            <td class="input-cell"><input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="short_description">Short Description</label></td>
                            <td class="input-cell"><textarea id="short_description" name="short_description" rows="2" class="myTextarea" required>{{ old('short_description', $category->short_discription ?? '') }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="description">Description</label></td>
                            <td class="input-cell"><textarea id="description" name="description" rows="4" class="myTextarea" required>{{ old('description', $category->discription ?? '') }}</textarea></td>
                        </tr>
                        <tr class="formbutton">
                            <td colspan="2">
                                <div style="text-align:center;">
                                    <button type="submit">{{ isset($category) ? 'Update Category' : 'Add Category' }}</button>
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

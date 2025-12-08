@extends('layouts.app')

@section('content')
    @include('admin.dash')
    <main>
        <div class="intro" style="padding:20px;font-size:16px;">
            <p>Welcome to the Admin Dashboard! Here you can manage items, categories and other settings.</p>
            <p>Use the navigation buttons above to access different sections of the dashboard.</p>
        </div>
    </main>
@endsection

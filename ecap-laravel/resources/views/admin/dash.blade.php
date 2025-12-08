<link rel="stylesheet" type="text/css" href="/css/adm/dash-adm.css">
<div class="dash-header">
    <h2><a href="{{ route('admin.dashboard') }}">Dashboard</a></h2>
    <div class="dash-btns">
        <a href="{{ route('admin.items.index') }}" class="dash-btn">List Items</a>
        <a href="{{ route('admin.categories.index') }}" class="dash-btn">List Categories</a>
        <a href="{{ route('admin.announcements.index') }}" class="dash-btn">Announcements</a>
        <a href="{{ route('admin.contacts.index') }}" class="dash-btn">Contacts</a>
    </div>
</div>

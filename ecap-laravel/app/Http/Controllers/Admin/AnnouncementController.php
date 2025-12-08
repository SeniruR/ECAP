<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('created_at')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'is_enabled' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('announcements', $filename, 'public');
            $data['image'] = Storage::url($path);
        }

        // Checkbox sends 'on' when checked; use has() to detect it reliably
        $data['is_enabled'] = $request->has('is_enabled');

        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('status','Announcement created');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'is_enabled' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            // remove old from storage disk if it was stored with Storage::url()
            if ($announcement->image && str_starts_with($announcement->image, '/storage/')) {
                $diskPath = ltrim(str_replace('/storage/', '', $announcement->image), '/');
                try { Storage::disk('public')->delete($diskPath); } catch (\Throwable $e) {}
            }

            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('announcements', $filename, 'public');
            $data['image'] = Storage::url($path);
        }

        // Checkbox sends 'on' when checked; detect presence
        $data['is_enabled'] = $request->has('is_enabled');

        $announcement->update($data);
        return redirect()->route('admin.announcements.index')->with('status','Announcement updated');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->image && str_starts_with($announcement->image, '/storage/')) {
            $diskPath = ltrim(str_replace('/storage/', '', $announcement->image), '/');
            try { Storage::disk('public')->delete($diskPath); } catch (\Throwable $e) {}
        }
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('status','Announcement removed');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_enabled' => ! $announcement->is_enabled]);
        return redirect()->back();
    }
}

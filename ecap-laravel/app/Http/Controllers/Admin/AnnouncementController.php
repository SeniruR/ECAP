<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

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
            $path = $request->file('image')->store('announcements', 'public');
            $data['image'] = '/storage/' . $path;
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
            // remove old
            if ($announcement->image) {
                try { @unlink(public_path(ltrim($announcement->image, '/'))); } catch (\Throwable $e) {}
            }
            $path = $request->file('image')->store('announcements', 'public');
            $data['image'] = '/storage/' . $path;
        }

        // Checkbox sends 'on' when checked; detect presence
        $data['is_enabled'] = $request->has('is_enabled');

        $announcement->update($data);
        return redirect()->route('admin.announcements.index')->with('status','Announcement updated');
    }

    public function destroy(Announcement $announcement)
    {
        if($announcement->image){ try{ @unlink(public_path(ltrim($announcement->image,'/'))); }catch(\Throwable$e){} }
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('status','Announcement removed');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_enabled' => ! $announcement->is_enabled]);
        return redirect()->back();
    }
}

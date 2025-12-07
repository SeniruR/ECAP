<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['itemType', 'images'])->orderByDesc('created')->get();
        $types = ItemType::orderBy('name')->get();
        return view('admin.items.index', compact('items', 'types'));
    }

    public function create()
    {
        $types = ItemType::orderBy('name')->get();
        return view('admin.items.create', compact('types'));
    }
    
    public function edit($no)
    {
        $item = Item::with('images')->findOrFail($no);
        $types = ItemType::orderBy('name')->get();
        return view('admin.items.create', compact('types', 'item'));
    }

    public function store(Request $request)
    {
        // Determine if this is an update (has `no`) or create
        $isUpdate = (bool) $request->input('no');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'short_dis' => ['required', 'string'],
            'long_dis' => ['required', 'string'],
            'type' => ['required', 'integer', 'exists:itemtypes,no'],
            'content' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'trademark' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];

        if ($isUpdate) {
            // images are optional on update; may append new images
            $rules['images'] = ['sometimes', 'array', 'max:8'];
            $rules['images.*'] = ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
        } else {
            // images required on create
            $rules['images'] = ['required', 'array', 'max:8'];
            $rules['images.*'] = ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
        }

        $validated = $request->validate($rules);

        $no = $request->input('no');

        DB::transaction(function () use ($validated, $no, $request) {
            if ($no) {
                $item = Item::findOrFail($no);
                $item->update([
                    'name' => $validated['name'],
                    'short_dis' => $validated['short_dis'],
                    'long_dis' => $validated['long_dis'],
                    'type' => $validated['type'],
                    'content' => $validated['content'] ?? null,
                    'benefits' => $validated['benefits'] ?? null,
                    'trademark' => $validated['trademark'] ?? null,
                    'price' => $validated['price'],
                ]);
            } else {
                $item = Item::create([
                    'name' => $validated['name'],
                    'short_dis' => $validated['short_dis'],
                    'long_dis' => $validated['long_dis'],
                    'type' => $validated['type'],
                    'content' => $validated['content'] ?? null,
                    'benefits' => $validated['benefits'] ?? null,
                    'trademark' => $validated['trademark'] ?? null,
                    'price' => $validated['price'],
                ]);
            }

            // handle uploaded images (append)
            foreach ($request->file('images', []) as $image) {
                $filename = Str::uuid()->toString().'.'.$image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');
                ItemImage::create([
                    'itemno' => $item->no,
                    'image' => Storage::url($path),
                ]);
            }
        });

        return redirect()->route('admin.items.index')->with('status', $no ? 'Item updated' : 'Item created');
    }

    public function toggle(Request $request, $no)
    {
        $item = Item::findOrFail($no);
        $item->inactive_status = !$item->inactive_status;
        $item->save();
        return redirect()->route('admin.items.index')->with('status', 'Item status updated');
    }

    public function destroy(Request $request, $no)
    {
        $item = Item::with('images')->findOrFail($no);
        foreach ($item->images as $img) {
            $path = $img->image;
            if (str_starts_with($path, '/storage/')) {
                $diskPath = ltrim(str_replace('/storage/', '', $path), '/');
                Storage::disk('public')->delete($diskPath);
            }
        }
        $item->delete();
        return redirect()->route('admin.items.index')->with('status', 'Item removed');
    }
}

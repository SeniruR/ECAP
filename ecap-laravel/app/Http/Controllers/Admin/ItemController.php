<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\ItemType;
use App\Http\Requests\ItemRequest as ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

    public function store(ItemRequest $request)
    {
        // validation is handled by ItemRequest
        $validated = $request->validated();

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
                // Verify file is a real image
                $tmpPath = $image->getPathname();
                $imgInfo = @getimagesize($tmpPath);
                if ($imgInfo === false) {
                    throw ValidationException::withMessages(['images' => 'One or more uploaded files are not valid images.']);
                }

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

    /**
     * Delete a single item image by id.
     */
    public function destroyImage(Request $request, $id)
    {
        $img = ItemImage::findOrFail($id);

        // delete file from storage if it was stored in /storage/
        $path = $img->image;
        if (str_starts_with($path, '/storage/')) {
            $diskPath = ltrim(str_replace('/storage/', '', $path), '/');
            Storage::disk('public')->delete($diskPath);
        }

        $itemNo = $img->itemno;
        $img->delete();

        return redirect()->route('admin.items.edit', $itemNo)->with('status', 'Image removed');
    }
}

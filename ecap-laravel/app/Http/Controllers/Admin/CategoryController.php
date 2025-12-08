<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $types = ItemType::orderBy('name')->get();
        return view('admin.categories.index', compact('types'));
    }

    public function create(Request $request)
    {
        $no = $request->query('no');
        $category = null;
        if ($no) {
            $category = ItemType::find($no);
        }
        return view('admin.categories.create', compact('category'));
    }

    public function edit($no)
    {
        $category = ItemType::findOrFail($no);
        return view('admin.categories.create', compact('category'));
    }

    public function toggle(Request $request, $no)
    {
        $type = ItemType::findOrFail($no);
        $type->inactive_status = !$type->inactive_status;
        $type->save();
        return redirect()->route('admin.categories.index')->with('status', 'Category status updated');
    }

    public function destroy(Request $request, $no)
    {
        $type = ItemType::with('items')->findOrFail($no);
        $itemsCount = $type->items->count();
        if ($itemsCount > 0) {
            // Prepare a small list of items (name + edit url) to show to the admin
            $items = $type->items->map(function($i){
                return ['name' => $i->name, 'url' => route('admin.items.edit', $i->getKey())];
            })->toArray();

            return redirect()->route('admin.categories.index')
                ->with('error', "Cannot remove category while {$itemsCount} item(s) are assigned to it. Remove all items before deleting the category.")
                ->with('error_items', $items);
        }

        $type->delete();
        return redirect()->route('admin.categories.index')->with('status', 'Category removed');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'no' => 'nullable|integer|exists:itemtypes,no',
        ]);

        $values = [
            'name' => $data['name'],
            'short_discription' => $data['short_description'] ?? null,
            'discription' => $data['description'] ?? null,
            'inactive_status' => 0,
        ];

        if (!empty($data['no'])) {
            $type = ItemType::find($data['no']);
            if ($type) {
                $type->update($values);
            }
        } else {
            ItemType::create($values);
        }

        return redirect()->route('admin.categories.index')->with('status', 'Category saved');
    }
}

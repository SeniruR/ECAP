<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // only show active categories in public navigation
        $types = ItemType::where('inactive_status', false)->orderBy('name')->get();
        // Only show active items on public pages
        $items = Item::with(['images', 'itemType'])
            ->where('inactive_status', false)
            ->whereHas('itemType', function($q) {
                $q->where('inactive_status', false);
            })
            ->orderByDesc('created')
            ->get();

        return view('items.index', [
            'types' => $types,
            'items' => $items,
        ]);
    }

    public function listAll(Request $request)
    {
        $typeId = $request->query('type');
        // if a specific category was requested, refuse access when it's disabled
        if ($typeId) {
            $requestedType = ItemType::find($typeId);
            if (!$requestedType || $requestedType->inactive_status) {
                return redirect()->route('home')->with('status', 'Category is disabled');
            }
        }

        // only show active categories in public navigation
        $types = ItemType::where('inactive_status', false)->orderBy('name')->get();
        $type = null;

        $items = Item::with(['images', 'itemType'])
            ->when($typeId, fn ($q) => $q->where('type', $typeId))
            ->where('inactive_status', false)
            ->whereHas('itemType', function($q) {
                $q->where('inactive_status', false);
            })
            ->orderByDesc('created')
            ->get();

        if ($typeId) {
            $type = $types->firstWhere('no', (int) $typeId);
        }

        return view('items.listall', [
            'type' => $type,
            'types' => $types,
            'items' => $items,
        ]);
    }

    public function show($no)
    {
        $item = Item::with(['images', 'itemType'])->find($no);
        if (!$item || $item->inactive_status || ($item->itemType && $item->itemType->inactive_status)) {
            return redirect()->route('home');
        }

        return view('items.show', [
            'item' => $item,
            'images' => $item->images,
        ]);
    }
}

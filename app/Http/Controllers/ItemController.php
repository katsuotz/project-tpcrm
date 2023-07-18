<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Warehouse;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        return view('items.index', [
            'warehouse' => $warehouse,
            'items' => Item::where('warehouse_id', $warehouse->id)->with('category')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Warehouse $warehouse)
    {
        return view('items.form', [
            'warehouse' => $warehouse,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request, Warehouse $warehouse)
    {
        $image = $request->image;
        $path = null;

        if ($image && $image->isValid()) {
            $filename = date('mdYHis') . uniqid() . '.' . $image->extension();
            $folder = $warehouse->id . '-' . $warehouse->name;
            $path = $folder . '/' . $filename;
            $image->storeAs('public', $path);
        }

        Item::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'stock' => 0,
            'warehouse_id' => $warehouse->id,
            'category_id' => $request->category,
            'image' => $path,
        ]);

        return redirect()->route('items.index', $warehouse)->with('success', 'Item Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse, Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse, Item $item)
    {
        return view('items.form', [
            'warehouse' => $warehouse,
            'categories' => Category::orderBy('name')->get(),
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Warehouse $warehouse, Item $item)
    {
        $image = $request->image;
        $path = $item->image;

        if ($image && $image->isValid()) {
            $filename = date('mdYHis') . uniqid() . '.' . $image->extension();
            $folder = $warehouse->id . '-' . $warehouse->name;
            $path = $folder . '/' . $filename;
            $image->storeAs('public', $path);
        }

        $item->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'warehouse_id' => $warehouse->id,
            'category_id' => $request->category,
            'image' => $path,
        ]);

        return redirect()->route('items.index', $warehouse)->with('success', 'Item Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse, Item $item)
    {
        $item->delete();
        return redirect()->route('items.index', $warehouse)->with('success', 'Item Deleted');
    }
}

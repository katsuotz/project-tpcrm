<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemLog;
use App\Http\Requests\StoreItemLogRequest;
use App\Http\Requests\UpdateItemLogRequest;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ItemLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Warehouse $warehouse, Item $item)
    {
        return view('items.stock-form', [
            'warehouse' => $warehouse,
            'item' => $item,
            'type' => 'add',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function remove(Warehouse $warehouse, Item $item)
    {
        return view('items.stock-form', [
            'warehouse' => $warehouse,
            'item' => $item,
            'type' => 'remove',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Warehouse $warehouse, Item $item, StoreItemLogRequest $request)
    {
        try {
            DB::beginTransaction();

            $qty = $request->qty;

            if ($request->type == 'remove')
                $qty *= -1;

            $item->stock += $qty;
            $item->save();

            $image = $request->image;
            $path = null;

            if ($image && $image->isValid()) {
                $filename = date('mdYHis') . uniqid() . '.' . $image->extension();
                $folder = $warehouse->id . '-' . $warehouse->name . '/transactions';
                $path = $folder . '/' . $filename;
                $image->storeAs('public', $path);
            }

            ItemLog::create([
                'item_id' => $item->id,
                'qty' => $qty,
                'price' => $request->price,
                'type' => $request->type,
                'image' => $path,
            ]);

            DB::commit();

            return redirect()->route('items.index', $warehouse)->with('success', 'Stock Successfully Added');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('success', 'Failed to Update Stock');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemLog $itemLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemLog $itemLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemLogRequest $request, ItemLog $itemLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemLog $itemLog)
    {
        //
    }
}

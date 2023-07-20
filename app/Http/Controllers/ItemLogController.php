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
            $total_price = 0;
            $price = $request->price;

            if ($price) {
                $total_price = $price * $qty;
            }

            if ($request->type == 'remove') {
                $qty *= -1;
            }

            $item->stock += $qty;

            if ($total_price) {
                if ($request->type == 'add') $item->expenses += $total_price;
                else $item->income += $total_price;
            }

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
                'qty' => $request->qty,
                'price' => $price,
                'type' => $request->type,
                'image' => $path,
            ]);

            DB::commit();

            return redirect()->route('items.index', $warehouse)->with('success', 'Stock Successfully Updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('success', 'Failed to Update Stock');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemLog $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse, Item $item, ItemLog $log)
    {
        return view('items.stock-form', [
            'warehouse' => $warehouse,
            'item' => $item,
            'type' => $log->type,
            'log' => $log,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemLogRequest $request, Warehouse $warehouse, Item $item, ItemLog $log)
    {
        try {
            DB::beginTransaction();

            // revert transaction

            $qty = $log->qty;
            $price = $log->price;

            $total_price = 0;

            if ($price) {
                $total_price = $price * $qty;
            }

            if ($log->type == 'remove') {
                $qty *= -1;
            }

            if ($total_price) {
                if ($log->type == 'add') $item->expenses -= $total_price;
                else $item->income -= $total_price;
            }

            $item->stock -= $qty;

            // update new transaction

            $qty = $request->qty;
            $total_price = 0;
            $price = $request->price;

            if ($price) {
                $total_price = $price * $qty;
            }

            if ($request->type == 'remove') {
                $qty *= -1;
            }

            $item->stock += $qty;

            if ($total_price) {
                if ($request->type == 'add') $item->expenses += $total_price;
                else $item->income += $total_price;
            }

            $item->save();

            $image = $request->image;
            $path = null;

            if ($image && $image->isValid()) {
                $filename = date('mdYHis') . uniqid() . '.' . $image->extension();
                $folder = $warehouse->id . '-' . $warehouse->name . '/transactions';
                $path = $folder . '/' . $filename;
                $image->storeAs('public', $path);
            }

            $log->update([
                'item_id' => $item->id,
                'qty' => $request->qty,
                'price' => $price,
                'type' => $request->type,
                'image' => $path,
            ]);

            DB::commit();

            return redirect()->route('items.index', $warehouse)->with('success', 'Stock Successfully Updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('success', 'Failed to Update Stock');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse, Item $item, ItemLog $log)
    {
        try {
            DB::beginTransaction();
            $qty = $log->qty;
            $price = $log->price;

            $total_price = 0;

            if ($price) {
                $total_price = $price * $qty;
            }

            if ($log->type == 'remove') {
                $qty *= -1;
            }

            if ($total_price) {
                if ($log->type == 'add') $item->expenses -= $total_price;
                else $item->income -= $total_price;
            }

            $item->stock -= $qty;
            $item->save();

            $log->delete();

            DB::commit();

            return redirect()->route('items.show', ['warehouse' => $warehouse, 'item' => $item])->with('success', 'Delete Log Success');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('success', 'Failed to Delete Stock');
        }
    }
}

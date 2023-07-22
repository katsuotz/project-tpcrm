<?php

namespace App\Exports;

use App\Models\ItemLog;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemLogExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function forItem(int $item)
    {
        $this->item = $item;

        return $this;
    }

    public function query()
    {
        return ItemLog::query()->where('item_id', $this->item)->selectRaw('type, price, qty, created_at');
    }

    public function map($logs): array
    {
        return [
            $logs->type,
            $logs->price,
            $logs->qty,
            ($logs->type == 'add' ? '-' : '') . ($logs->price * $logs->qty),
            $logs->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            "Type",
            "Price",
            "Qty",
            "Total Price",
            "Time",
        ];
    }
}

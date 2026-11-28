<?php

namespace App\Observers;

use App\Models\PrinterModel;
use Illuminate\Support\Facades\Cache;

class PrinterModelObserver
{
    public function saved(PrinterModel $printerModel): void
    {
        $this->flushPrinterCaches();
    }

    public function deleted(PrinterModel $printerModel): void
    {
        $this->flushPrinterCaches();
    }

    private function flushPrinterCaches(): void
    {
        Cache::forget('printer_brands_list');
    }
}

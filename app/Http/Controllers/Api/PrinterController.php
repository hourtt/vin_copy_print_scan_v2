<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrinterResource;
use App\Models\PrinterModel as Printer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // Filtering the printers by brand id
        $query = Printer::with('brand');
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $printers = $query->orderBy('created_at', 'desc')->paginate(10);

        return PrinterResource::collection($printers);
    }

    /**
     * Return a single printer model with its brand
     * and the products compatible with it.
     */
    public function show(string $id): PrinterResource
    {
        $printer = Printer::with('brand', 'compatibleProducts.brand', 'compatibleProducts.category')
            ->findOrFail($id);

        return new PrinterResource($printer);
    }
}

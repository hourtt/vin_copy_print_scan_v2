<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrinterResource;
use App\Models\PrinterModel as Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Return a single printer model with its brand
     * and the products compatible with it.
     */
    public function show(string $id)
    {
        $printer = Printer::with('brand', 'compatibleProducts.brand', 'compatibleProducts.category')
            ->findOrFail($id);

        return new PrinterResource($printer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

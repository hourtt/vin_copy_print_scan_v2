<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminInquiryController extends Controller
{
    /**
     * Display the paginated inquiry log with optional date-range and search filters.
     */
    public function index(Request $request): View
    {
        $query = Inquiry::with('user', 'product')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name_snapshot', 'like', "%{$search}%")
                  ->orWhere('product_name_snapshot', 'like', "%{$search}%")
                  ->orWhere('user_email_snapshot', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(20)->withQueryString();

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'date_from' => $request->date_from,
            'date_to'   => $request->date_to,
            'search'    => $request->search,
        ]);
    }

    /**
     * Export a filtered inquiry log as a PDF.
     */
    public function export(Request $request)
    {
        $query = Inquiry::with('user', 'product')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name_snapshot', 'like', "%{$search}%")
                  ->orWhere('product_name_snapshot', 'like', "%{$search}%")
                  ->orWhere('user_email_snapshot', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->get();

        $pdf = Pdf::loadView('admin.inquiries.export-pdf', [
            'inquiries' => $inquiries,
            'date_from' => $request->date_from,
            'date_to'   => $request->date_to,
            'generated' => now()->format('d M Y, H:i'),
        ])->setPaper('a4', 'landscape');

        $filename = 'inquiries-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceExportController extends Controller
{
    public function exportPdf()
    {
        // Ambil data lengkap yang dibutuhkan
        $services = Service::with(['serviceCategory','resident.user'])
            ->latest()
            ->get();

        // Set timezone Asia/Makassar saat format di view
        $timezone = 'Asia/Makassar';

        // Opsi dompdf (opsional)
        $pdf = PDF::loadView('exports.services-pdf', compact('services','timezone'))
            ->setPaper('a4', 'landscape'); // ubah ke 'landscape' jika tabel lebar

        // Nama file dengan tanggal
        $filename = 'data-tamu-'.Carbon::now($timezone)->format('Ymd_His').'.pdf';

        // stream() untuk pratinjau di browser, download() untuk langsung unduh
        return $pdf->download($filename);
    }
}

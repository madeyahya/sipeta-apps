<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Resident;
use App\Models\Service;



class DashboardController extends Controller
{
    public function index()
    {
        $totalResidents = Resident::count();
        $totalServices  = Service::count();

        // Data untuk grafik (per bulan)
        $months = collect(range(1, 12))->map(function ($m) {
            return date('F', mktime(0, 0, 0, $m, 1));
        });

        $residentData = Resident::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $serviceData = Service::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // isi 0 untuk bulan yg kosong
        $residentCounts = [];
        $serviceCounts = [];
        foreach (range(1, 12) as $m) {
            $residentCounts[] = $residentData[$m] ?? 0;
            $serviceCounts[]  = $serviceData[$m] ?? 0;
        }

        return view('pages.admin.dashboard', [
            'totalResidents' => $totalResidents,
            'totalServices'  => $totalServices,
            'months'         => $months,
            'residentData'   => $residentCounts,
            'serviceData'    => $serviceCounts,
        ]);
    }
}

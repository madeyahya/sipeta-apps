<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\ServiceCategoryRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{   
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceCategoryRepositoryInterface $serviceCategoryRepository;

    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        ServiceCategoryRepositoryInterface $serviceCategoryRepository
    )
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index(Request $request)
    {
        $categories = $this->serviceCategoryRepository->getAllServiceCategories();

        // ambil resident_id dari user login
        $residentId = Auth::user()?->resident?->id;

        // (opsional) jika mau filter status via query ?status=completed|delivered|...
        $status = $request->query('status');

        $services = $residentId
            ? $this->serviceRepository->getServicesByResidentId($residentId, $status)
            : $this->serviceRepository->getLatestServices();

        return view('pages.app.home', compact('categories', 'services'));
    }
}

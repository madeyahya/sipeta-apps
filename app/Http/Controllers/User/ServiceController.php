<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Interfaces\ServiceCategoryRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceCategoryRepositoryInterface $serviceCategoryRepository;

    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        ServiceCategoryRepositoryInterface $serviceCategoryRepository,
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index(Request $request)
{
    // validasi ringan
    $request->validate([
        'resident_id' => 'nullable|integer|exists:residents,id',
        'category'    => 'nullable|string',
        'status'      => 'nullable|in:delivered,in_process,rejected,completed',
    ]);

    // ambil resident_id dari query atau dari user login
    $residentId = $request->integer('resident_id') ?: Auth::user()?->resident?->id;
    $category   = $request->get('category');
    $status     = $request->get('status'); // opsional

    if ($residentId && $category) {
        $services = $this->serviceRepository->getServicesByResidentAndCategory($residentId, $category, $status);
    } elseif ($residentId) {
        $services = $this->serviceRepository->getServicesByResidentId($residentId, $status);
    } elseif ($category) {
        $services = $this->serviceRepository->getServicesByCategory($category);
    } else {
        $services = $this->serviceRepository->getAllServices();
    }

    return view('pages.app.service.index', compact('services'));
}

    public function myService(Request $request)
    {
        $residentId = Auth::user()?->resident?->id; // pastikan user punya resident
        $status     = $request->input('status');    // opsional

        $services = $this->serviceRepository->getServicesByResidentId((int) $residentId, $status);

        return view('pages.app.service.my-service', compact('services'));
    }

    public function show($code)
    {
        $service = $this->serviceRepository->getServiceByCode($code);

        return view('pages.app.service.show', compact('service'));
    }

    public function take()
    {
        return view('pages.app.service.take');
    }

    public function preview()
    {
        return view('pages.app.service.preview');
    }

    public function create()
    {
        $categories = $this->serviceCategoryRepository->getAllServiceCategories();

        return view('pages.app.service.create', compact('categories'));
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();

        $data['code'] = 'BK' . mt_rand(100000, 999999);
        $data['resident_id'] = Auth::user()->resident->id;
        $data['image'] = $request->file('image')->store('assets/service/image', 'public');


        $this->serviceRepository->createService($data);

        return redirect()->route('service.success');
    }

    public function success()
    {
        return view('pages.app.service.success');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Interfaces\ResidentRepositoryInterface;
use App\Interfaces\ServiceCategoryRepositoryInterface;
use App\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ServiceController extends Controller
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceCategoryRepositoryInterface $serviceCategoryRepository;
    private ResidentRepositoryInterface $residentRepository;

    public function __construct(
        ServiceRepositoryInterface $serviceRepository,
        ServiceCategoryRepositoryInterface $serviceCategoryRepository,
        ResidentRepositoryInterface $residentRepository
    )

    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceCategoryRepository = $serviceCategoryRepository;
        $this->residentRepository = $residentRepository;
    }

    public function index()
    {
        $services = $this->serviceRepository->getAllServices();

        return view('pages.admin.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->serviceCategoryRepository->getAllServiceCategories();

        return view('pages.admin.service.create', compact('residents', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request -> validated();

        $data ['code'] = 'BK' . mt_rand(100000, 999999);

        $data['image'] = $request->file('image')->store('assets/service/image', 'public');

        $this->serviceRepository->createService($data);

        Swal::toast('Data Kategori Berhasil Ditambah', 'success')->timerProgressBar();

        return redirect()->route('admin.service.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = $this->serviceRepository->getServiceById($id);

        return view('pages.admin.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = $this->serviceRepository->getServiceById($id);
        $residents = $this->residentRepository->getAllResidents();
        $categories = $this->serviceCategoryRepository->getAllServiceCategories();

        return view('pages.admin.service.edit', compact('service', 'residents', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id)
    {
        $data = $request->validated();
        
        if ($request->image){
            $data['image'] = $request->file('image')->store('assets/image', 'public');
        }

        $this->serviceRepository->updateService($data, $id);

          Swal::toast('Data Tamu Berhasil Diperbarui', 'success')->timerProgressBar();

        return redirect()->route('admin.service.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->serviceRepository->deleteService($id);
        Swal::toast('Data Pelayanan Berhasil Dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.service.index');
    }
}

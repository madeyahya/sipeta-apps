<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceStatusRequest;
use App\Http\Requests\UpdateServiceStatusRequest;
use App\Interfaces\ServiceRepositoryInterface;
use App\Interfaces\ServiceStatusRepositoryInterface;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class ServiceStatusController extends Controller
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceStatusRepositoryInterface $serviceStatusRepository;

    public function __construct(
        ServiceRepository $serviceRepository,
        ServiceStatusRepositoryInterface $serviceStatusRepository,
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->serviceStatusRepository = $serviceStatusRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($serviceId)
    {
        $service = $this->serviceRepository->getServiceById($serviceId);
        
        return view('pages.admin.service-status.create', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceStatusRequest $request)
    {
        $data = $request->validated();

        if ($request->image) {
            $data['image'] = $request->file('image')->store('assets/service-status/image', 'public');
        }

        $this->serviceStatusRepository->createServiceStatus($data);

        Swal::toast('Data Progress Berhasil Ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.service.show', $request->service_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = $this->serviceStatusRepository->getServiceStatusById($id);

        return view('pages.admin.service-status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceStatusRequest $request, string $id)
    {
        $data = $request->validated();

        if ($request->image) {
            $data['image'] = $request->file('image')->store('assets/service-status/image', 'public');
        }

        $this->serviceStatusRepository->updateServiceStatus($data, $id);

        Swal::toast('Data Progress Berhasil Diperbarui', 'success')->timerProgressBar();

        return redirect()->route('admin.service.show', $request->service_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = $this->serviceStatusRepository->getServiceStatusById($id);

        $this->serviceStatusRepository->deleteServiceStatus($id);

        Swal::toast('Data Progress Berhasil Dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.service.show', $status->service_id);
    }
}

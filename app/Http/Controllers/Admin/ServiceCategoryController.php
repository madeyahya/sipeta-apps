<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use App\Interfaces\ServiceCategoryRepositoryInterface;
use App\Repositories\ServiceCategoryRepository;
use RealRashid\SweetAlert\Facades\Alert as Swal;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    private ServiceCategoryRepositoryInterface $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepositoryInterface $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index()
    {
        $categories = $this->serviceCategoryRepository->getAllServiceCategories();

        return view('pages.admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceCategoryRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('image')->store('service-category/image', 'public_uploads');
        // simpan "service-category/image/<file>" ke DB
        $data['image'] = 'uploads/' . $path; // simpan sudah dengan prefix 'uploads/'

        $this->serviceCategoryRepository->createServiceCategory($data);

        Swal::toast('Data Kategori Berhasil Ditambah', 'success')->timerProgressBar();

        return redirect()->route('admin.service-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->serviceCategoryRepository->getServiceCategoryById($id);

        return view('pages.admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->serviceCategoryRepository->getServiceCategoryById($id);

        return view('pages.admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceCategoryRequest $request, string $id)
    {
        $data = $request->validated();

        if ($request->image) {
            $data['image'] = $request->file('image')->store('assets/image', 'public');
        }

        $this->serviceCategoryRepository->updateServiceCategory($data, $id);

        Swal::toast('Data Kategori Berhasil Diperbarui', 'success')->timerProgressBar();

        return redirect()->route('admin.service-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->serviceCategoryRepository->deleteServiceCategory($id);
        Swal::toast('Data Kategori Berhasil Dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.service-category.index');
    }
}

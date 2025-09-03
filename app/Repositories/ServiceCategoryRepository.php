<?php

namespace App\Repositories;

use App\Interfaces\ServiceCategoryRepositoryInterface;
use App\Models\ServiceCategory;

class ServiceCategoryRepository implements ServiceCategoryRepositoryInterface
{
    public function getAllServiceCategories()
    {
        return ServiceCategory::all();
    }

    public function getServiceCategoryById(int $id)
    {
        return ServiceCategory::where('id', $id)->first();
    }

    public function createServiceCategory(array $data)
    {
        return ServiceCategory::create($data);
    }
    
    public function updateServiceCategory(array $data, int $id)
    {
        $serviceCategory = $this->getservicecategoryById($id);

        return $serviceCategory->update($data);
    }

    public function deleteservicecategory(int $id)
    {
        $serviceCategory = $this->getservicecategoryById($id);
        
        return $serviceCategory->delete();
    }
}
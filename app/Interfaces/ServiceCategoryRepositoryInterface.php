<?php

namespace App\Interfaces;

interface ServiceCategoryRepositoryInterface{
    public function getAllServiceCategories();

    public function getServiceCategoryById(int $id);

    public function createServiceCategory(array $data);

    public function updateServiceCategory(array $data, int $id);

    public function deleteServiceCategory(int $id);
}
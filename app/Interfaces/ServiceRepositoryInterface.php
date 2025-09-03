<?php

namespace App\Interfaces;

interface ServiceRepositoryInterface {
    public function getAllServices();
    public function getLatestServices(int $limit = 5);

    public function getServicesByResidentId(int $residentId, ?string $status = null);
    public function getServicesByResidentAndCategory(int $residentId, string $category, ?string $status = null);

    public function getServiceById(int $id);
    public function getServiceByCode(string $code);
    public function getServicesByCategory(string $category);
    public function createService(array $data);
    public function updateService(array $data, int $id);
    public function deleteService(int $id);
}
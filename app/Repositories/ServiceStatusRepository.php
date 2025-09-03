<?php

namespace App\Repositories;

use App\Interfaces\ServiceStatusRepositoryInterface;
use App\Models\ServiceStatus;

class ServiceStatusRepository implements ServiceStatusRepositoryInterface
{
    public function getAllServiceStatuses()
    {
        return ServiceStatus::all();
    }

    public function getServiceStatusById(int $id)
    {
        return ServiceStatus::where('id', $id)->first();
    }

    public function createServiceStatus(array $data)
    {
        return ServiceStatus::create($data);
    }
    
    public function updateServiceStatus(array $data, int $id)
    {
        $serviceStatus = $this->getServiceStatusById($id);

        return $serviceStatus->update($data);
    }

    public function deleteServiceStatus(int $id)
    {
        $serviceStatus = $this->getServiceStatusById($id);
        
        return $serviceStatus->delete();
    }
}
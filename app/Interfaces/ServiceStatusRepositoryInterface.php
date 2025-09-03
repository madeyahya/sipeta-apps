<?php

namespace App\Interfaces;

interface ServiceStatusRepositoryInterface{
    public function getAllServiceStatuses();

    public function getServiceStatusById(int $id);

    public function createServiceStatus(array $data);

    public function updateServiceStatus(array $data, int $id);

    public function deleteServiceStatus(int $id);
}
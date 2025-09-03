<?php

namespace App\Repositories;

use App\Interfaces\ServiceRepositoryInterface;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ServiceRepository implements ServiceRepositoryInterface
{
     public function getAllServices()
    {
        return Service::with(['serviceCategory'])->latest()->get();
    }

    public function getLatestServices(int $limit = 5)
    {
        return Service::with(['serviceCategory'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getServicesByResidentId(int $residentId, ?string $status = null)
    {
        $q = Service::with(['serviceCategory', 'serviceStatuses'])
            ->where('resident_id', $residentId)
            ->latest();

        if ($status !== null) {
            // pastikan status TERAKHIR = $status
            $q->whereHas('serviceStatuses', function (Builder $query) use ($status) {
                $query->where('status', $status)
                      ->whereIn('id', function ($sub) {
                          $sub->selectRaw('MAX(id)')
                              ->from('service_statuses')
                              ->groupBy('service_id');
                      });
            });
        }

        return $q->get();
    }

    public function getServicesByResidentAndCategory(int $residentId, string $category, ?string $status = null)
    {
        $q = Service::with(['serviceCategory', 'serviceStatuses'])
            ->where('resident_id', $residentId)
            // cocokkan kategori berdasarkan NAME (lebih rapi pakai slug kalau ada)
            ->whereHas('serviceCategory', fn (Builder $qq) => $qq->where('name', $category))
            ->latest();

        if ($status !== null) {
            $q->whereHas('serviceStatuses', function (Builder $query) use ($status) {
                $query->where('status', $status)
                      ->whereIn('id', function ($sub) {
                          $sub->selectRaw('MAX(id)')
                              ->from('service_statuses')
                              ->groupBy('service_id');
                      });
            });
        }

        return $q->get();
    }

    public function getServiceById(int $id)
    {
        return Service::with('serviceCategory')->where('id', $id)->first();
    }

    public function getServiceByCode(string $code)
    {
        return Service::with('serviceCategory')->where('code', $code)->first();
    }

    public function createService(array $data)
    {
        $service = Service::create($data);

        $service->serviceStatuses()->create([
            'status'      => 'delivered',
            'description' => 'Pengajuan Berhasil Diterima',
        ]);

        return $service->load('serviceCategory');
    }

    public function getServicesByCategory(string $category)
    {
        // hindari query kategori terpisah: gunakan whereHas agar aman bila tidak ada
        return Service::with('serviceCategory')
            ->whereHas('serviceCategory', fn (Builder $q) => $q->where('name', $category))
            ->latest()
            ->get();
    }

    public function updateService(array $data, int $id)
    {
        $service = $this->getServiceById($id);
        return $service?->update($data);
    }

    public function deleteService(int $id)
    {
        $service = $this->getServiceById($id);
        return $service?->delete();
    }
}
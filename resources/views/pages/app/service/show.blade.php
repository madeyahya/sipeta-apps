@extends('layouts.no-nav')

@section('title', $service->code)

@section('content')
@php
$lastStatus = optional($service->serviceStatuses)->last();
$status = $lastStatus->status ?? null;
@endphp

{{-- Header --}}
<div class="d-flex align-items-center gap-3 border-bottom pb-3">
    <a href="{{ route('home') }}" class="text-decoration-none">
        <img src="{{ asset('assets/app/images/icons/ArrowLeft.svg') }}" alt="Kembali" width="24" height="24">
    </a>
    <div class="flex-grow-1">
        <h1 class="h5 m-0">Detail Pengajuan Layanan</h1>
        <div class="text-secondary small">{{ $service->code }}</div>
    </div>

    @switch($status)
    @case('delivered') <span class="badge bg-primary">Terkirim</span> @break
    @case('in_process') <span class="badge bg-warning text-dark">Diproses</span> @break
    @case('rejected') <span class="badge bg-danger">Ditolak</span> @break
    @case('completed') <span class="badge bg-success">Selesai</span> @break
    @default <span class="badge bg-secondary">Tidak diketahui</span>
    @endswitch
</div>

{{-- Gambar utama (klik untuk modal) --}}
@if ($service->image)
<img
    src="{{ asset('storage/' . $service->image) }}"
    alt="{{ $service->title }}"
    class="img-fluid rounded-3 mt-4 shadow-sm"
    loading="lazy"
    role="button"
    data-bs-toggle="modal"
    data-bs-target="#imageModal">
@endif

<h2 class="h5 fw-semibold mt-3 text-break">{{ $service->title }}</h2>

{{-- Detail informasi --}}
<div class="card mt-3">
    <div class="card-header fw-bold">Detail Informasi</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <span class="text-secondary">Kode</span>
            <span class="fw-semibold text-break text-end">{{ $service->code }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <span class="text-secondary">Tanggal</span>
            <span class="fw-semibold text-break text-end">
                {{ \Carbon\Carbon::parse($service->created_at)->timezone('Asia/Makassar')->format('d M Y H:i') }} WITA
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <span class="text-secondary">Kategori</span>
            <span class="fw-semibold text-break text-end">
                {{ $service->serviceCategory->name }}
            </span>
        </li>
    </ul>
</div>

{{-- Riwayat perkembangan --}}
<div class="card mt-4">
    <div class="card-header fw-bold">Riwayat Perkembangan</div>
    <ul class="list-group list-group-flush">
        @foreach ($service->serviceStatuses as $item)
        <li class="list-group-item">
            <div class="small text-secondary mb-1">
                {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Makassar')->format('d M Y H:i')  }} WITA
            </div>
            <div class="mb-1">{{ $item->description }}</div>

            @if ($item->image)
            <button
                type="button"
                class="btn btn-sm btn-outline-secondary"
                data-bs-toggle="modal"
                data-bs-target="#statusImageModal"
                data-image="{{ asset('storage/' . $item->image) }}">
                Lihat gambar
            </button>
            @endif
        </li>
        @endforeach
    </ul>
</div>

{{-- Modal gambar utama --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0 text-center">
                <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid rounded" alt="{{ $service->title }}">
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk gambar di riwayat --}}
<div class="modal fade" id="statusImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0 text-center">
                <img id="statusImagePreview" src="" class="img-fluid rounded" alt="Lampiran status">
            </div>
        </div>
    </div>
</div>

{{-- Script kecil untuk ganti src modal riwayat --}}
<script>
    document.addEventListener('show.bs.modal', function(e) {
        if (e.target && e.target.id === 'statusImageModal') {
            const trigger = e.relatedTarget;
            const src = trigger?.getAttribute('data-image');
            if (src) document.getElementById('statusImagePreview').setAttribute('src', src);
        }
    });
</script>
@endsection
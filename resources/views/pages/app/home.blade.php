@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="max-w-screen-sm mx-auto bg-white min-vh-100 p-3">
    <div class="header-nav">
        <h3 class="h5 m-0 d-flex align-items-center gap-2 lh-1">
            <img
                src="{{ asset('assets/app/images/icons/sipeta.png') }}"
                alt="Logo SIPETA"
                style="height:1.5em;width:auto;display:block;"
                class="flex-shrink-0">
            <span class="fw-bold">SiPeTa</span>
        </h3>
    </div>

    <br>
    <br>

    <div class="d-flex align-items-center justify-content-between gap-4 py-3 overflow-auto" id="category" style="white-space: nowrap;">
        @foreach ($categories as $category)
        <a href="{{ route('service.index', ['category' => $category->name]) }}" class="category d-inline-block">
            <div class="icon">
                <img src="{{ asset('storage/' . $category->image) }}" alt="icon">
            </div>
            <p>{{ $category->name }}</p>
        </a>
        @endforeach
    </div>

    <div class="d-flex flex-column gap-1 mt-1">
        <div class="d-flex flex-column gap-3 mt-3">
            @forelse ($services as $service)
            @php
            $lastStatus = optional($service->serviceStatuses)->last();
            $status = $lastStatus->status ?? null;
            @endphp

            <a href="{{ route('service.show', $service->code) }}" class="card border-0 shadow-sm text-decoration-none text-dark">
                <div class="card-body p-3">
                    <div class="card-report-image position-relative mb-2"
                        style="height: 180px; overflow: hidden; border-radius: .5rem;">
                        <img src="{{ asset('storage/' . $service->image) }}"
                            alt=""
                            class="w-100 h-100"
                            style="object-fit: cover; border-radius: .5rem;">

                        @if ($status === 'delivered')
                        <span class="badge rounded-pill bg-primary position-absolute top-0 end-0 m-2">Terkirim</span>
                        @elseif ($status === 'in_process')
                        <span class="badge rounded-pill bg-warning text-dark position-absolute top-0 end-0 m-2">Diproses</span>
                        @elseif ($status === 'rejected')
                        <span class="badge rounded-pill bg-danger position-absolute top-0 end-0 m-2">Ditolak</span>
                        @elseif ($status === 'completed')
                        <span class="badge rounded-pill bg-success position-absolute top-0 end-0 m-2">Selesai</span>
                        @endif
                    </div>

                    <h2 class="h6 fw-semibold lh-sm mb-1"
                        style="display:-webkit-box;-webkit-line-clamp: 2;
line-clamp: 2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $service->title }}
                    </h2>

                    <div class="text-secondary small d-flex flex-wrap gap-2">
                        <span>{{ \Carbon\Carbon::parse($service->created_at)->format('d M Y') }}</span>
                        <span>•</span>
                        <span>{{ $service->serviceCategory->name }}</span>
                        <span>•</span>
                        <span>{{ $service->code }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh" id="no-reports">
                <div id="lottie"></div>
                <h5 class="mt-3">Belum ada laporan</h5>
                <a href="" class="btn btn-primary py-2 px-4 mt-3">
                    Buat Laporan
                </a>
            </div>
            @endforelse
        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        var animation = bodymovin.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "{{ asset('assets/app/lottie/not-found.json') }}"
        })
    </script>

    @endsection
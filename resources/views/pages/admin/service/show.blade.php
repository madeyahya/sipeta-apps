@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<!-- Page Heading -->
<a href="{{route('admin.service.index')}}" class="btn btn-danger mb-3">Kembali</a>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Pengajuan</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td>Kode Pengajuan</td>
                <td>{{$service->code}}</td>
            </tr>
            <tr>
                <td>Tamu</td>
                <td>{{$service->resident->user->email}} - {{$service->resident->user->name}}</td>
            </tr>
            <tr>
                <td>Kategori Pengajuan</td>
                <td>{{$service->serviceCategory->name}}</td>
            </tr>
            <tr>
                <td>Title</td>
                <td>{{$service->title}}</td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>{{$service->description}}</td>
            </tr>
            <tr>
                <td>Bukti Pengajuan</td>
                <td>
                     @if($service->image)
                <!-- Gambar kecil (klik → buka modal) -->
                <img src="{{ asset('storage/'.$service->image) }}"
                    alt="image"
                    width="120"
                    class="img-thumbnail d-block mb-3"
                    style="cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#imageModal">
                @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card shadow mb-5">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Progress Laporan</h6>
    </div>
    <div class="card-body">
        <a href="{{route('admin.service-status.create', $service->id)}}" class="btn btn-primary mb-3">Tambah Progress</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($service->serviceStatuses as $status)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($status->image)
                            <img src="{{asset('storage/' .$status->image)}}" alt="image" width="100">
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            {{ $status->status}}
                        </td>
                        <td>
                            {{ $status->description}}
                        </td>
                        <td>
                            <a href="{{route('admin.service-status.edit', $status->id)}}" class="btn btn-warning">Edit</a>

                            <form action="{{route('admin.service-status.destroy', $status->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Bootstrap untuk preview gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/'.$service->image) }}"
                    class="img-fluid rounded"
                    alt="image">
            </div>
        </div>
    </div>
</div>
@endsection
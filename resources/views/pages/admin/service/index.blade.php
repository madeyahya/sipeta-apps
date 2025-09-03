@extends('layouts.admin')

@section('title', 'Data Pengajuan')

@section('content')
<a href="{{route('admin.service.create')}}" class="btn btn-primary mb-3">Tambah Data</a>
<a href="{{ route('admin.service.export.pdf') }}" class="btn btn-danger mb-3 ms-4">
    Export PDF
</a>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Data Pengajuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width:2%">Kode Pengajuan</th>
                        <th style="width:22%">Tamu</th>
                        <th>Kategori Pengajuan</th>
                        <th>Judul Pengajuan</th>
                        <th>Bukti Pengajuan</th>
                        <th style="width:19%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$service->code}}</td>
                        <td>{{$service->resident->user->name ?? ''}}</td>
                        <td>{{$service->serviceCategory->name ?? ''}}</td>
                        <td>{{$service->title}}</td>
                        <td>
                            <img src="{{asset('storage/' .$service->image)}}" alt="image" width="100">
                        </td>
                        <td>
                            <a href="{{route('admin.service.edit', $service->id)}}" class="btn btn-warning">Edit</a>

                            <a href="{{route('admin.service.show', $service->id)}}" class="btn btn-info">Show</a>

                            <form action="{{route('admin.service.destroy', $service->id)}}" method="POST" class="d-inline">
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

@endsection
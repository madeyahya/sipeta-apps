@extends('layouts.admin')

@section('title', 'Kategori Pengajuan')

@section('content')
<a href="{{route('admin.service-category.create')}}" class="btn btn-primary mb-3">Tambah Data</a>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori Pengajuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Icon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$category->name}}</td>
                        <td class="text-center">
                            <img src="{{ url('storage/'.$category->image) }}" width="100" alt="image">

                        </td>
                        <td>
                            <a href="{{route('admin.service-category.edit', $category->id)}}" class="btn btn-warning">Edit</a>

                            <a href="{{route('admin.service-category.show', $category->id)}}" class="btn btn-info">Show</a>

                            <form action="{{route('admin.service-category.destroy', $category->id)}}" method="POST" class="d-inline">
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
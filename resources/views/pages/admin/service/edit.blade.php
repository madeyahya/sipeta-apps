@extends('layouts.admin')

@section('title', 'Edit Data Pengajuan')

@section('content')

<!-- Page Heading -->
<a href="{{route('admin.service.index')}}" class="btn btn-danger mb-3">Kembali</a>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Pengajuan</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.service.update', $service->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="code">Kode</label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                    name="code" value="{{$service->code}}" disabled>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="resident">Tamu</label>

                <select name="resident_id" class="form-control @error('resident_id') is-invalid @enderror">
                    @foreach ($residents as $resident)
                    <option value="{{ $resident->id}}" @if (old('resident_id', $service->resident_id) == $resident->id) selected @endif>
                        {{ $resident->user->email}} - {{$resident->user->name}}
                    </option>
                    @endforeach
                </select>
                @error('resident')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="service_category_id" class="form-control @error('service_category_id') is-invalid @enderror">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id}}" @if (old('service_category_id', $service->service_category_id) == $category->id) selected @endif>
                        {{$category->name}}
                    </option>
                    @endforeach
                </select>
                @error('service_category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="title">Judul Pengajuan</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{old('title', $service->title)}}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Pengajuan</label>
                <textarea type="text area" class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" value="{{old('description', $service->description)}}" rows="5">{{old('description', $service->description)}}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Bukti Pengajuan</label>

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

                <!-- Input file -->
                <input type="file"
                    class="form-control @error('image') is-invalid @enderror"
                    id="image"
                    name="image">

                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<!-- Page Heading -->
<a href="{{route('admin.service-category.index')}}" class="btn btn-danger mb-3">Kembali</a>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Kategori</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td>Nama</td>
                <td>{{$category->name}}</td>
            </tr>
            <tr>
                <td>Ikon</td>
                <td>
                    @php use Illuminate\Support\Facades\Storage; @endphp
                    <img src="{{ Storage::disk('public_uploads')->url($category->image) }}" width="200" alt="image">

                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
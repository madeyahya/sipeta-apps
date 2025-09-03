@extends('layouts.no-nav')

@section('title', 'Tambah')

@section('content')
<div class="header-nav">
    <h3 class="h5 m-0 d-flex align-items-center gap-2 lh-1">
        <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <img
                src="{{ asset('assets/app/images/icons/sipeta.png') }}"
                alt="Logo SIPETA"
                style="height:1.5em;width:auto;display:block;"
                class="flex-shrink-0">
            <span class="fw-bold text-dark">SiPeTa</span>
        </a>
    </h3>
</div>

<br>
<br>
<br>

<p class="text-description">Silakan mengisi formulir di bawah ini dengan baik, benar, dan lengkap. Data yang Anda berikan akan sangat membantu agar
    informasi yang tercatat sesuai kebutuhan serta dapat diproses dengan cepat dan tepat</p>

<form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
    @csrf
    <input type="hidden" id="lat" name="lat">
    <input type="hidden" id="lng" name="lng">

    <div class="mb-3">
        <label for="title" class="form-label">Judul Pengajuan</label>
        <input type="text" class="form-control @error ('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">

        @error('title')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="service_category_id" class="form-label">Kategori Pengajuan</label>

        <select name="service_category_id" class="form-control @error('service_category_id') is-invalid @enderror">
            @foreach ($categories as $category)
            <option value="{{ $category->id}}" @if (old('service_category_id')==$category->id) selected @endif>
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

    <div class="mb-3">
        <label for="image" class="form-label">Bukti Pengajuan</label>

        {{-- input file disembunyikan tapi tetap bisa dipicu via JS --}}
        <input
            type="file"
            id="image"
            name="image"
            accept="image/*"
            capture="environment"
            class="visually-hidden ">

        {{-- wrapper agar tombol selalu di bawah gambar --}}
        <div class="d-flex flex-column align-items-center">
            {{-- kotak preview (tinggi tetap) --}}
            <div id="previewBox"
                class="w-100 bg-light border rounded-2 d-flex align-items-center justify-content-center"
                style="height:240px; overflow:hidden;">
                <img id="image-preview"
                    alt="Preview bukti laporan"
                    class="img-fluid d-none"
                    style="max-height:100%; object-fit:contain;">
                <span id="placeholder" class="text-muted small">Belum ada gambar</span>
            </div>

            {{-- tombol di bawah gambar --}}
            <button type="button" id="pickImageBtn" class="btn btn-outline-primary mt-2 w-100">
                Pilih / Ambil Foto
            </button>
        </div>

        @error('image')
        <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea type="text area" class="form-control @error('description') is-invalid @enderror" id="description"
            name="description" value="{{old('description')}}" rows="5"> </textarea>

        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

        @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-2">Periksa kembali isian Anda:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <button class="btn btn-primary w-100 mt-2" type="submit" color="primary">
            Kirim
        </button>
</form>
@endsection

@section('scripts')
<script defer>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('image');
        const btn = document.getElementById('pickImageBtn');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('placeholder');

        btn.addEventListener('click', () => input.click());
        preview.addEventListener('click', () => input.click());

        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }

            const url = URL.createObjectURL(file);
            preview.src = url;
            preview.classList.remove('d-none');
            placeholder?.classList.add('d-none');

            preview.onload = () => URL.revokeObjectURL(url);
        });
    });
</script>

@endsection
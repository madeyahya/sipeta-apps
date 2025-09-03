@extends('layouts.no-nav')

@section('title', 'Preview Foto')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center">
  <img alt="Preview" id="image-preview" class="img-fluid rounded-2">

  <div class="d-flex justify-content-center mt-3 gap-3">
    <a href="{{ route('service.take') }}" class="btn btn-outline-primary">Ulangi Foto</a>
    <a href="{{ route('service.create') }}" class="btn btn-primary">Gunakan Foto</a>
    {{-- atau ganti dengan form submit base64 sesuai alurmu --}}
  </div>
</div>
@endsection

@section('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', () => {
  const img = localStorage.getItem('snapshot'); // <-- pakai 'snapshot'
  const el  = document.getElementById('image-preview');

  if (img) {
    el.src = img;
  } else {
    el.alt = 'Tidak ada gambar';
    // opsional: tampilkan pesan dan tombol kembali
    el.insertAdjacentHTML('afterend', `
      <p class="text-muted mt-3">
        Tidak ada gambar di memori. <a href="{{ route('service.take') }}">Ambil ulang</a>
      </p>
    `);
  }
});
</script>
@endsection

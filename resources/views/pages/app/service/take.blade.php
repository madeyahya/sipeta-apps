@extends('layouts.no-nav')

@section('title', 'Ambil Foto')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
  <video id="video-webcam" autoplay playsinline muted
         style="max-width:480px;width:100%;background:#000;border-radius:.5rem;"></video>

  <div class="mt-3 d-flex gap-2">
    <button type="button" id="btnStart" class="btn btn-outline-primary">Aktifkan Kamera</button>
  </div>

  {{-- Fallback: input file langsung buka kamera HP bila gUM gagal --}}
  <input id="fileCamera" type="file" accept="image/*" capture="environment" class="d-none">
</div>

<script defer>
(() => {
  const video = document.getElementById('video-webcam');
  const btnStart = document.getElementById('btnStart');
  const btnSnap  = document.getElementById('btnSnap');
  const fileCam  = document.getElementById('fileCamera');

  let stream = null;

  function explain(err) {
    const map = {
      NotAllowedError: 'Izin kamera ditolak. Cek pengaturan situs & izinkan kamera.',
      NotFoundError: 'Tidak ada kamera terdeteksi.',
      NotReadableError: 'Kamera dipakai aplikasi lain.',
      OverconstrainedError: 'Kamera tidak memenuhi syarat (constraints).',
      SecurityError: 'Harus via HTTPS atau http://localhost.',
    };
    return map[err?.name] || ('Gagal akses kamera: ' + (err?.name || err));
  }

  async function startCamera() {
    if (!navigator.mediaDevices?.getUserMedia) {
      // Browser terlalu lama → pakai fallback
      fileCam.click();
      return;
    }
    // Coba kamera belakang, fallback ke default
    const c1 = { video: { facingMode: { ideal: 'environment' } }, audio: false };
    const c2 = { video: true, audio: false };
    try {
      stream = await navigator.mediaDevices.getUserMedia(c1).catch(() => navigator.mediaDevices.getUserMedia(c2));
      video.srcObject = stream;
      try { await video.play(); } catch {}
    } catch (err) {
      alert(explain(err));
      // Fallback langsung ke input file (kamera sistem)
      fileCam.click();
    }
  }

  function stopCamera() {
    if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
  }

  async function takeSnapshot() {
    if (!video.srcObject) { alert('Kamera belum aktif.'); return; }
    if (!video.videoWidth || !video.videoHeight) {
      await new Promise(res => video.addEventListener('loadedmetadata', res, { once: true }));
    }
    const canvas = document.createElement('canvas');
    const targetW = Math.min(1080, video.videoWidth);
    const scale   = targetW / video.videoWidth;
    const targetH = Math.round(video.videoHeight * scale);

    canvas.width = targetW; canvas.height = targetH;
    canvas.getContext('2d').drawImage(video, 0, 0, targetW, targetH);

    const dataURL = canvas.toDataURL('image/jpeg', 0.9);
    try { localStorage.setItem('snapshot', dataURL); } catch {}
    // arahkan ke halaman preview (pakai route kamu sendiri)
    window.location.href = "{{route('service.preview')}}";
  }

  // Fallback file → simpan ke localStorage juga agar reuse preview yang sama
  fileCam.addEventListener('change', () => {
    const f = fileCam.files?.[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = () => {
      try { localStorage.setItem('snapshot', reader.result); } catch {}
      window.location.href = "{{route('service.preview')}}";
    };
    reader.readAsDataURL(f);
  });

  btnStart.addEventListener('click', startCamera);
  btnSnap.addEventListener('click', takeSnapshot);

  // Bereskan stream saat pindah halaman / tab disembunyikan
  window.addEventListener('pagehide', stopCamera);
})();
</script>
@endsection
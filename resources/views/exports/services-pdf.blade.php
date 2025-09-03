@php
    use Carbon\Carbon;
    /** @var \Illuminate\Support\Collection|\App\Models\Service[] $services */
    $nowWita = Carbon::now($timezone ?? 'Asia/Makassar');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Tamu</title>
    <style>
        @page { margin: 24px 28px 60px 28px; } /* top right bottom left */
        * { font-family: DejaVu Sans, Arial, sans-serif; }
        body { font-size: 12px; color: #222; }

        h2 { margin: 0 0 6px 0; font-size: 16px; text-align: center; }
        .meta {
            text-align: center; font-size: 11px; color: #555; margin-bottom: 12px;
        }

        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #444; padding: 6px 8px; }
        th {
            background: #f4f6f8; font-weight: bold; text-align: left;
            font-size: 12px;
        }
        tbody tr:nth-child(odd) { background: #fcfcfc; }
        tbody tr:nth-child(even) { background: #ffffff; }

        /* Kolom lebar agar rapi di A4 portrait */
        .w-5 { width: 6%; }
        .w-12 { width: 12%; }
        .w-18 { width: 18%; }
        .w-20 { width: 20%; }
        .w-15 { width: 15%; }
        .w-10 { width: 10%; }

        /* Bungkus teks panjang */
        .wrap { word-wrap: break-word; overflow-wrap: break-word; }

        /* Footer nomor halaman */
        .footer {
            position: fixed;
            left: 0; right: 0; bottom: 18px;
            text-align: right; font-size: 10px; color: #555;
            padding: 0 28px;
        }
    </style>
</head>
<body>
    <h2>Daftar Data Tamu</h2>
    <div class="meta">
        Dicetak: {{ $nowWita->timezone($timezone ?? 'Asia/Makassar')->translatedFormat('d F Y H:i') }} WITA
        &middot; Total: {{ $services->count() }} data
    </div>

    <table>
        <thead>
            <tr>
                <th class="w-5">No</th>
                <th class="w-12">Kode</th>
                <th class="w-18">Nama Tamu</th>
                <th class="w-15">Kategori</th>
                <th class="w-20">Judul Pengajuan</th>
                <th class="w-10">Tanggal</th>
                <th class="w-10">Jam</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($services as $i => $service)
            @php
                $dt = Carbon::parse($service->created_at)->timezone($timezone ?? 'Asia/Makassar');
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="wrap">{{ $service->code }}</td>
                <td class="wrap">{{ $service->resident->user->name ?? '-' }}</td>
                <td class="wrap">{{ $service->serviceCategory->name ?? '-' }}</td>
                <td class="wrap">{{ $service->title }}</td>
                <td>{{ $dt->translatedFormat('d F Y') }}</td>
                <td>{{ $dt->format('H:i') }} WITA</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Footer nomor halaman untuk Dompdf --}}
    <div class="footer">
        {{-- akan diisi via script php di bawah --}}
    </div>

    {{-- Dompdf: script untuk nomor halaman --}}
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("DejaVu Sans", "normal");
            $size = 9;
            $text = "Halaman {PAGE_NUM} / {PAGE_COUNT}";
            // Posisi kanan bawah, sesuaikan koordinat jika margin diubah
            $pdf->page_text($pdf->get_width() - 120, $pdf->get_height() - 40, $text, $font, $size, [0,0,0]);
        }
    </script>
</body>
</html>

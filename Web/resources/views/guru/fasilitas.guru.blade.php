<!DOCTYPE html>
<html>
<head>
    <title>Fasilitas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f7fb;">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2 class="mb-4">Daftar Fasilitas</h2>

        <div class="row">

            @forelse($fasilitas as $item)

            <div class="col-md-4 mb-4">

                <div class="card h-100 shadow-sm">

                    <div class="card-body">

                        <h4>
                            {{ $item->nama_fasilitas }}
                        </h4>

                        <p>
                            {{ $item->deskripsi }}
                        </p>

                        <hr>

                        <p>
                            <b>Harga:</b><br>
                            Rp {{ number_format($item->harga) }}
                        </p>

                        <p>
                            <b>Lokasi:</b><br>
                            {{ $item->lokasi }}
                        </p>

                        <p>
                            <b>Kapasitas:</b><br>
                            {{ $item->kapasitas }}
                        </p>

                        <p>
                            <b>Status:</b><br>

                            @if($item->status == 'tersedia')

                                <span class="badge bg-success">
                                    Tersedia
                                </span>

                            @elseif($item->status == 'maintenance')

                                <span class="badge bg-warning">
                                    Maintenance
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Tidak Tersedia
                                </span>

                            @endif

                        </p>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12">

                <div class="alert alert-danger">
                    Data fasilitas kosong
                </div>

            </div>

            @endforelse

        </div>

    </div>

</div>

</body>
</html>
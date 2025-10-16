<?php
// ==== Data Dummy (bisa diganti data database MySQL) ====
$total_hibah = 960000000;
$jumlah_barang = 150;
$jumlah_penerima = 15;

$data_proporsi = [
    "Kendaraan" => 30,
    "Alat Mesin Pertanian" => 35,
    "Sarana" => 20,
    "Lainnya" => 15
];

$data_aset = [
    ["nomor" => "001", "barang" => "Traktor", "tahun" => 2022],
    ["nomor" => "002", "barang" => "Pompa Air", "tahun" => 2023],
    ["nomor" => "003", "barang" => "Eskavator", "tahun" => 2024] // ✅ Data baru ditambahkan di sini
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Hibah Digital DTPH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 1rem; }
        .section-title { font-weight: 600; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📊 Dashboard Hibah Digital DTPH</h3>
        <button class="btn btn-outline-primary">Admin</button>
    </div>

    <!-- Ringkasan Data -->
    <div class="card shadow-sm mb-4 p-3">
        <h5 class="section-title">⭐ Ringkasan Data Hibah</h5>
        <div class="row text-center">
            <div class="col-md-4">
                <h4>Rp <?= number_format($total_hibah, 0, ',', '.'); ?></h4>
                <p>Total Nilai Hibah 2023</p>
            </div>
            <div class="col-md-4">
                <h4><?= $jumlah_barang; ?></h4>
                <p>Jumlah Barang</p>
            </div>
            <div class="col-md-4">
                <h4><?= $jumlah_penerima; ?></h4>
                <p>Jumlah Penerima</p>
            </div>
        </div>
        <canvas id="trenHibah" height="80"></canvas>
    </div>

    <div class="row g-4">
        <!-- Proporsi Hibah -->
        <div class="col-md-5">
            <div class="card shadow-sm p-3">
                <h6 class="section-title text-center">Proporsi Hibah</h6>
                <canvas id="proporsiHibah"></canvas>
            </div>
        </div>

        <!-- Daftar Aset Hibah -->
        <div class="col-md-7">
            <div class="card shadow-sm p-3">
                <h6 class="section-title">Daftar Aset Hibah</h6>
                <table class="table table-bordered text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Nomor</th>
                            <th>Jenis Barang</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_aset as $row): ?>
                            <tr>
                                <td><?= $row['nomor']; ?></td>
                                <td><?= $row['barang']; ?></td>
                                <td><?= $row['tahun']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Hibah Berdasarkan Asal & Tujuan -->
    <div class="card shadow-sm p-3 mt-4">
    <h6 class="section-title">Data Hibah Berdasarkan Asal & Tujuan</h6>
    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Asal Hibah</th>
                    <th>Tujuan Hibah</th>
                    <th>Status Distribusi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kementerian</td>
                    <td>UPTD</td>
                    <td>
                        <span class="text-success fw-semibold">✅ Selesai</span>
                    </td>
                </tr>
                <tr>
                    <td>Pemerintah Pusat</td>
                    <td>Kabupaten/Kota</td>
                    <td>
                        <span class="text-warning fw-semibold">⏳ Proses</span>
                    </td>
                </tr>
                <tr>
                    <td>Lembaga Donor</td>
                    <td>Kelompok Tani</td>
                    <td>
                        <span class="text-danger fw-semibold">❌ Belum Terealisasi</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    <!-- Dokumen & Monitoring -->
    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="section-title">📄 Dokumen & Arsip Digital</h6>
                <ul>
                    <li>BAST</li>
                    <li>SK Penetapan Hibah</li>
                    <li>Berita Acara Pemeriksaan Barang</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="section-title">🕵️ Monitoring & Evaluasi</h6>
                <ul>
                    <li>Status pelaporan</li>
                    <li>Jadwal monitoring</li>
                    <li>Rekap hasil verifikasi</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script>
const ctxPie = document.getElementById('proporsiHibah');
new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_keys($data_proporsi)); ?>,
        datasets: [{
            data: <?= json_encode(array_values($data_proporsi)); ?>,
            backgroundColor: ['#0d6efd','#28a745','#ffc107','#6c757d']
        }]
    }
});

const ctxLine = document.getElementById('trenHibah');
new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Tren Hibah',
            data: [5,10,15,20,18,25,30,28,35,40,38,45],
            borderColor: '#0d6efd',
            fill: false,
            tension: 0.3
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

</body>
</html>

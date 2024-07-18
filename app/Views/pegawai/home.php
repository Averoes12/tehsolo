<?= $this->extend('pegawai/nav') ?>  

<?= $this->section('judul') ?>
<h3>Selamat Datang</h3>
<?= $this->endsection() ?>


<?= $this->section('isi') ?>
<div class="row">
    <div class="col-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_in; ?></h3>
                <p>Transaksi Penjualan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-4">
    <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_out; ?></h3>
                <p>Transaksi Pembelian Bahan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <div class="col-4">
    <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $totalTransaksi; ?></h3>
                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp <?= number_format(($totalIncome > 0) ? $totalIncome : 0.00); ?></h3>
                <p>Total Pendapatan</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp <?= number_format(($totalOutcome > 0) ? $totalOutcome : 0.00); ?></h3>
                <p>Total Pengeluaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= number_format((($totalIncome - $totalOutcome) > 0) ? ($totalIncome - $totalOutcome) : 0.00); ?></h3>
                <p>Total Keuntungan</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Grafik Transaksi</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="areaChart" class="chartjs-render-monitor" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 441px;"></canvas>
                <script>
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    function generateRandomColors(length) {
                        var colors = [];
                        for (var i = 0; i < length; i++) {
                            colors.push(getRandomColor());
                        }
                        return colors;
                    }

                    var ctx = document.getElementById('areaChart').getContext('2d');
                    var transaksiByTanggalChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?= json_encode(array_column($transaksiByTanggal, 'tanggal')); ?>,
                            datasets: [{
                                label: 'Transaksi',
                                data: <?= json_encode(array_column($transaksiByTanggal, 'total_transaksi')); ?>,
                                backgroundColor: generateRandomColors(<?= count($transaksiByTanggal); ?>),
                                borderColor: generateRandomColors(<?= count($transaksiByTanggal); ?>),
                                borderWidth: 1
                            }]
                        }
                    });
                </script>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Menu Terlaris</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="donutChart" class="chartjs-render-monitor" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 441px;"></canvas>
                <script>
                    function getRandomColor() {
                        var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }

                    function generateRandomColors(length) {
                        var colors = [];
                        for (var i = 0; i < length; i++) {
                            colors.push(getRandomColor());
                        }

                        return colors;
                    }

                    var ctx = document.getElementById('donutChart').getContext('2d');
                    var transaksiByMenuChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: <?= json_encode(array_column($transaksiByMenu, 'nama_menu')); ?>,
                            datasets: [{
                                data: <?= json_encode(array_column($transaksiByMenu, 'total_transaksi')); ?>,
                                backgroundColor: generateRandomColors(<?= count($transaksiByMenu); ?>),
                                borderColor: generateRandomColors(<?= count($transaksiByMenu); ?>),
                                borderWidth: 1
                            }]
                        }
                    });
                </script>
            </div>

        </div>
    </div>
</div>
<?= $this->endsection() ?>
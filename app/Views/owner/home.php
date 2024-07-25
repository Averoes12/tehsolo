<?= $this->extend('owner/nav', $cabang) ?>

<?= $this->section('judul') ?>
<h3>Selamat Datang</h3>
<?= $this->endsection() ?>


<?= $this->section('isi') ?>
<div class="row">
    <div class="col-lg-9 mb-3">
    </div>
    <div class="col-lg-3 mb-3 text-right">
        <form method="POST" action="<?= base_url('owner/home') ?>">
            <?= csrf_field(); ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                    </span>
                </div>
                <input type="text" class="form-control float-right mr-2" name="date" value="<?= $date_range ?>" id="filter-date-range">
                <button class="btn btn-primary btn-sm" type="submit" id="date-range" name="filter">Filter</button>
            </div>
        </form>
    </div>
</div>
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
                <h3>Rp <?= number_format((($totalIncome - $totalOutcome) > 0) ? ($totalIncome - $totalOutcome) : 0.00); ?></h3>
                <p>Total Keuntungan</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill"></i>
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
                <h3 class="card-title">Transaksi Per Cabang</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="barChart" class="chartjs-render-monitor" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 441px;"></canvas>
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

                    var ctx = document.getElementById('barChart').getContext('2d');
                    var transaksiByCabangChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode(array_column($transaksiByCabang, 'nama_cabang')); ?>,
                            datasets: [{
                                label: 'Transaksi',
                                data: <?= json_encode(array_column($transaksiByCabang, 'total_transaksi')); ?>,
                                backgroundColor: generateRandomColors(<?= count($transaksiByCabang); ?>),
                                borderColor: generateRandomColors(<?= count($transaksiByCabang); ?>),
                                borderWidth: 1
                            }]
                        }
                    });
                </script>
            </div>

        </div>
    </div>
</div>
<div class="row">
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
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Summary Keuangan Cabang</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="branch-report" class="chartjs-render-monitor" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 441px;"></canvas>
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

                    var ctx = document.getElementById('branch-report').getContext('2d');
                    var transaksiByCabangChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode(array_column($laporanKeuangan, 'nama_cabang')); ?>,
                            datasets: [{
                                    label: 'Total Income',
                                    data: <?= json_encode(array_column($laporanKeuangan, 'total_income')); ?>,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Total Outcome',
                                    data: <?= json_encode(array_column($laporanKeuangan, 'total_outcome')); ?>,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Profit',
                                    data: <?= json_encode(array_column($laporanKeuangan, 'profit')); ?>,
                                    backgroundColor: "#470FF4",
                                    borderColor: "#470FF4",
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#filter-date-range').daterangepicker({
            timePicker: false,
            locale: {
                format: 'YYYY/MM/D hh:mm:ss'
            }
        });

    });
</script>
<?= $this->endsection() ?>
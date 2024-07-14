<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Selamat Datang</h3>
<?= $this->endsection() ?>


<?= $this->section('isi') ?>
<div class="row">
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
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Transaction Chart</h3>
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
    <div class="col-md-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Branch Chart</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
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
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Menu Chart</h3>
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
                                label: 'Transaksi',
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
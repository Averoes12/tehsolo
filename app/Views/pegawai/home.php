<?= $this->extend('pegawai/nav') ?>  

<?= $this->section('judul') ?>
<h3>Selamat Datang</h3>
<?= $this->endsection() ?>


<?= $this->section('isi') ?>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Selamat Datang </h5>
    Aplikasi Pencatatan Transaksi Siap di gunakan
</div>
<?= $this->endsection() ?>
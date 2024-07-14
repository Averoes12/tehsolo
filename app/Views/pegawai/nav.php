<?= $this->extend('pegawai/layout') ?>

<?= $this->section('nav') ?>
<li class="nav-item">
    <a href="<?= site_url('pegawai/home'); ?>" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Home
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('pegawai/transaksi'); ?>" class="nav-link">
        <i class="nav-icon fas fa-receipt"></i>
        <p>
            Daftar Transaksi
        </p>
    </a>
</li>
</li>
<?= $this->endsection() ?>
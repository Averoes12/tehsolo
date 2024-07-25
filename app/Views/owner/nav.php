<?= $this->extend('owner/layout') ?>

<?= $this->section('nav') ?>
<li class="nav-item">
    <a href="<?= site_url('owner/home'); ?>" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Home
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/transaksi'); ?>" class="nav-link">
        <i class="nav-icon fas fa-receipt"></i>
        <p>
            Transaksi
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/menu'); ?>" class="nav-link">
        <i class="nav-icon fas fa-utensils"></i>
        <p>
            Menu & Stok
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/cabang'); ?>" class="nav-link">
        <i class="nav-icon fas fa-building"></i>
        <p>
            Cabang
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/users'); ?>" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Kelola User
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>
            Laporan Cabang
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php foreach ($cabang as $e) { ?>
            <li class="nav-item">
                <a href="<?= site_url('owner/report/' . $e['id']) ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= strlen($e['nama_cabang']) > 20 ? substr($e['nama_cabang'], 0, 20) . "..." : $e['nama_cabang']; ?>
                    </p>
                </a>
            </li>
        <?php } ?>
    </ul>
</li>
<?= $this->endsection() ?>
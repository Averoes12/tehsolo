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
<?= $this->endsection() ?>
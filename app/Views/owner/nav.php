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
    <a href="<?= site_url('owner/menu'); ?>" class="nav-link">
        <i class="nav-icon fas fa-utensils"></i>
        <p>
            Daftar menu
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/cabang'); ?>" class="nav-link">
        <i class="nav-icon fas fa-building"></i>
        <p>
            Daftar Cabang
        </p>
    </a>
</li>
<li class="nav-item has-treeview">
    <a href="<?= site_url('owner/users'); ?>" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Kelola user
        </p>
    </a>
</li>
<?= $this->endsection() ?>
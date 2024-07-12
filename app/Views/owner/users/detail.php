<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Detail User</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('owner/users') ?>">Kelola Users</a></li>
<li class="breadcrumb-item active">Detail User</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="card col-md-8">
    <div class="card-header">
        <div class="card-body">
            <table class="table">
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><?= $user['username'] ?></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>:</td>
                    <td><?= $user['role'] ?></td>
                </tr>
                <?php if ($user['role'] != 'owner') { ?>
                    <tr>
                        <td>Nama Cabang</td>
                        <td>:</td>
                        <td><?= $user['nama_cabang'] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $user['alamat'] ?></td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>:</td>
                        <td><?= $user['telepon'] ?></td>
                    </tr>
                    <?php } ?>

            </table>
        </div>
    </div>
</div>

<?= $this->endsection() ?>
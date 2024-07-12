<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit Menu</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('owner/menu') ?>">Daftar Menu</a></li>
<li class="breadcrumb-item active">Edit Menu</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card">
    <div class="card-header">
        <form method="POST" action="<?= base_url('owner/menu/update/' . $menu['id']) ?>">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" class="form-control <?= ($validation->hasError('namamenu')) ? 'is-invalid' : '' ?>" name="namamenu" placeholder="Nama Menu" value="<?= $menu['nama_menu'] ?>">
                    <?php if ($validation->hasError('namamenu')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('namamenu') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" name="harga" placeholder="Harga" value="<?= $menu['harga'] ?>">
                    <?php if ($validation->hasError('harga')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="text" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : '' ?>" name="stok" placeholder="Stok" value="<?= $menu['stok'] ?>">
                    <?php if ($validation->hasError('stok')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('stok') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Cabang</label>
                    <select name="id_cabang" class="form-control <?= ($validation->hasError('id_cabang')) ? 'is-invalid' : '' ?>">
                        <?php foreach ($cabang as $c) : ?>
                            <option value="<?= $c['id'] ?>" <?= $c['id'] == $menu['id_cabang'] ? 'selected' : '' ?>>
                                <?= $c['nama_cabang'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($validation->hasError('id_cabang')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('id_cabang') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php if (session()->getFlashdata('toast') == 'success'): ?>
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Data Berhasil diedit",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?= $this->endsection() ?>
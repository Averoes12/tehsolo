<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit Cabang</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('owner/cabang') ?>">Daftar Cabang</a></li>
<li class="breadcrumb-item active">Edit Cabang</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card">
    <div class="card-header">
        <form method="POST" action="<?= base_url('owner/cabang/update/' . $cabang['id']) ?>">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Cabang</label>
                    <input type="text" class="form-control <?= ($validation->hasError('namacabang')) ? 'is-invalid' : '' ?>" name="namacabang" placeholder="Nama Cabang" value="<?= $cabang['nama_cabang'] ?>">
                    <?php if ($validation->hasError('namacabang')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('namacabang') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control <?= ($validation->hasError('alamatcabang')) ? 'is-invalid' : '' ?>" name="alamatcabang" placeholder="Alamat Cabang" value="<?= $cabang['alamat'] ?>">
                    <?php if ($validation->hasError('alamatcabang')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamatcabang') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="number" class="form-control <?= ($validation->hasError('teleponcabang')) ? 'is-invalid' : '' ?>" name="teleponcabang" placeholder="Telepon Cabang" value="<?= $cabang['telepon'] ?>">
                    <?php if ($validation->hasError('teleponcabang')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('teleponcabang') ?>
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
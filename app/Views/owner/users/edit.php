<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit User</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('owner/users') ?>">Kelola Users</a></li>
<li class="breadcrumb-item active">Edit User</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <form method="POST" action="<?= base_url('owner/users/update/' . $user['id']) ?>">
            <?= csrf_field(); ?>
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" name="username" value="<?= $user['username'] ?>">
                    <?php if ($validation->hasError('username')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="toggle-hint-password">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>" name="role" value="<?= $user['role'] ?>" readonly>
                    <?php if ($validation->hasError('role')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('role') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Cabang</label>
                    <select name="id_cabang" class="form-control <?= ($validation->hasError('id_cabang')) ? 'is-invalid' : '' ?>">
                        <?php foreach ($cabang as $c) : ?>
                            <option value="<?= $c['id'] ?>" <?= $c['id'] == $user['id_cabang'] ? 'selected' : '' ?>>
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
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php if (session()->getFlashdata('toast') == 'success') : ?>
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Data berhasil diedit",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $("#toggle-hint-password").click(function() {
            if ($("#toggle-hint-password i").hasClass("fa-eye")) {
                $("#toggle-hint-password i").removeClass("fa-eye");
                $("#toggle-hint-password i").addClass("fa-eye-slash");
                $("#password").attr("type", "password");
            } else {
                $("#toggle-hint-password i").removeClass("fa-eye-slash");
                $("#toggle-hint-password i").addClass("fa-eye");
                $("#password").attr("type", "text");
            }
        });
    })
</script>

<?= $this->endsection() ?>
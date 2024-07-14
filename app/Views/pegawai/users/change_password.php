<?= $this->extend('pegawai/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit Menu</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item active">Ganti Password</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card">
    <div class="card-header">
        <form method="POST" action="<?= base_url('pegawai/users/update/' . session('id_user')) ?>">
            <div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control <?= ($validation->hasError('namamenu')) ? 'is-invalid' : '' ?>" placeholder="Username" value="<?= session('username') ?>" readonly>
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
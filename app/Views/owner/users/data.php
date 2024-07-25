<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Kelola Users</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item active">Kelola Users</li>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-primary tombolTambah">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </h3>

    </div>
    <div class="card-body">
        <form method="POST" action="<?= base_url('owner/users/data') ?>">
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari username" name="cariusers" autofocus
                    value="<?= $cari; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="tombolusers">Cari</button>
                </div>
        </form>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Cabang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $nomor = 1;
                if (count($datausers) > 0) {
                    foreach ($datausers as $row):
                        ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['role']; ?></td>
                            <td><?= $row['nama_cabang']; ?></td>
                            <td align="right">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    onclick="hapus('<?= $row['id'] ?>')">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                <a href="<?= base_url('owner/users/edit/' . $row['id']) ?>"
                                    class="btn btn-outline-primary btn-sm"> <i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('owner/users/detail/' . $row['id']) ?>" class="btn btn-primary btn-sm"> <i
                                        class="fas fa-search-plus"></i></a>

                            </td>
                        </tr>
                    <?php endforeach;
                } else { ?>
                    <td colspan="5" align="center">Nothing data found</td>
                <?php } ?>
            </tbody>
        </table>

        <div class="float-center">
            <?= $pager->links('default', 'paging_data') ?>
        </div>
        <!-- /.card-footer-->
    </div>
</div>

<div class="modal fade" id="modaltambahmenu" tabindex="-1" role="dialog" aria-labelledby="modaltambahmenu"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahmenu">Tambah menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('owner/users/simpandata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" id="username" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
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
                    <label for="">Role</label>
                    <input type="text" name="role" id="role" class="form-control form-control-sm" value="Pegawai"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="cabang">Cabang</label>
                    <select name="id_cabang" id="id_cabang" class="form-control form-control-sm select2" required>
                        <option value="">-- Pilih Cabang --</option>
                        <?php foreach ($cabang as $e) { ?>
                            <option value="<?= $e['id'] ?>"><?= $e['nama_cabang'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    function hapus(kode) {
        swal({
            title: "Hapus Data Menu",
            text: "Yakin Anda Ingin Menghapus Menu Ini",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "delete",
                        url: "<?= site_url('owner/users/hapus/') ?>" + kode,
                        dataType: "json",
                        success: function (response) {
                            if (response.sukses) {
                                swal({
                                    title: "Berhasil",
                                    text: response.sukses,
                                    icon: "success",
                                }).then((value) => {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    }



    $(document).ready(function () {
        $('.tombolTambah').click(function (e) {
            e.preventDefault();
            $('#modaltambahmenu').modal('show');

            // $.ajax({
            //     url: "<?= site_url('owner/users/formTambah') ?>",
            //     dataType: "json",
            //     success: function(response) {
            //         if (response.data) {
            //             $('.viewmodal').html(response.data).show();

            //             $('#modaltambahmenu').on('show.bs.modal', function(e) {
            //                 $('#namamenu').focus();
            //             });
            //             $('#modaltambahmenu').modal('show');
            //         }
            //     },
            //     error: function(xhr, ajaxOptions, thrownError) {
            //         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            //     }
            // });
        });

        $('.formsimpan').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function (e) {
                    $('.tombolSimpan').prop('disabled', true);
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function (response) {
                    console.log(response);
                    if (response.sukses) {
                        Swal.fire({
                            title: "berhasil",
                            text: response.sukses,
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                            window.location.reload();
                        });

                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $("#toggle-hint-password").click(function () {
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
    });
</script>

<?= $this->endsection() ?>
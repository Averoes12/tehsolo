<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Daftar Menu</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item active">Daftar Menu</li>
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

        <form method="POST" action="<?= base_url('owner/menu/data') ?>">
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Nama Menu minuman" name="carimenu" autofocus value="<?= $cari; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="tombolmenu">Cari</button>
                </div>
        </form>

        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Cabang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $nomor = 1;
                if (count($datamenu) > 0) {
                    foreach ($datamenu as $row) :
                ?>
                        <tr>
                            <td><?= $nomor++; ?></td>
                            <td <?= $row['stok'] < 10 ? "style='color: red;'" : "" ?>><?= $row['nama_menu']; ?></td>
                            <td <?= $row['stok'] < 10 ? "style='color: red;'" : "" ?>><?= number_format($row['harga']); ?></td>
                            <td <?= $row['stok'] < 10 ? "style='color: red;'" : "" ?>><?= number_format($row['stok']) ?></td>
                            <td <?= $row['stok'] < 10 ? "style='color: red;'" : "" ?>><?= ($row['nama_cabang'] == null || $row['nama_cabang'] == 0) ? "All" : $row['nama_cabang'] ?></td>
                            <td align="right">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="hapus('<?= $row['id'] ?>')">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                                <a href="<?= base_url('owner/menu/edit/' . $row['id']) ?>" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;
                } else { ?>
                    <td colspan="6" align="center">Nothind data found</td>
                <?php } ?>
            </tbody>
        </table>

        <div class="float-center">
        </div>
        <!-- /.card-footer-->
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
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
                        url: "<?= site_url('owner/menu/hapus/') ?>" + kode,
                        dataType: "json",
                        success: function(response) {
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
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    }



    $(document).ready(function() {
        $('.tombolTambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('owner/menu/formTambah') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahmenu').on('show.bs.modal', function(e) {
                            $('#namamenu').focus();
                            $(".select2").select2();
                        });
                        $('#modaltambahmenu').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endsection() ?>
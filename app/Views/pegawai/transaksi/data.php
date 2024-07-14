<?= $this->extend('pegawai/nav') ?>

<?= $this->section('judul') ?>
<h3>Daftar Transaksi</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item active">Daftar Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-primary tombolTambah">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">

        <form method="POST" action="<?= base_url('pegawai/transaksi/data') ?>">
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Nama Menu" name="caritransaksi" autofocus value="<?= $cari; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="tomboltransaksi">Cari</button>
                </div>
        </form>

        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Transaksi</th>
                    <th>Nama Menu</th>
                    <th>Cabang</th>
                    <th>Nominal</th>
                    <th>Quantity</th>
                    <th>Create By</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php $nomor = 1 + (($nohalaman - 1) * 5);
                if(count($datatrx) > 0) {
                foreach ($datatrx as $row) :
                    $data = base64_encode($row['id']."*".$row['id_menu']);
                ?>
                    <tr>
                        <td ><?= $nomor++; ?></td>
                        <td><?= $row['trx_date']; ?></td>
                        <td><?= $row['nama_menu']; ?></td>
                        <td><?= ($row['nama_cabang'] == null || $row['nama_cabang'] == 0) ? "All" : $row['nama_cabang'] ?></td>
                        <td align="right"><?= number_format($row['nominal']) ?></td>
                        <td align="right"><?= number_format($row['quantity']) ?></td>
                        <td><?= $row['createby'] ?></td>
                        <td align="right">
                            <a href="<?= base_url('pegawai/transaksi/edit/' . $data) ?>" class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; } else { ?>
                  <td colspan="8" align="center">Nothing data found</td>
                  <?php } ?>
            </tbody>
        </table>

        <div class="float-center">
            <?= $pager->links('pegawai/menu', 'paging_data'); ?>
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
                        url: "<?= site_url('pegawai/transaksi/hapus/') ?>" + kode,
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
                url: "<?= site_url('pegawai/transaksi/formTambah') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahtrx').on('show.bs.modal', function(e) {
                            $('#type').focus();

                        });
                        $('#modaltambahtrx').modal('show');
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
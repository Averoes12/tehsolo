<?= $this->extend('owner/nav') ?>

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
            <button type="button" class="btn btn-sm btn-outline-danger tombolPengeluaran">
                <i class="fa fa-plus"></i> Catat Pengeluaran
            </button>
        </h3>


    </div>
    <div class="card-body">

        <form method="POST" action="<?= base_url('owner/transaksi/data') ?>">
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
                    <th>Cabang</th>
                    <th>Create By</th>
                    <th>Update By</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $nomor = 1;
                if (count($datatrx) > 0) {
                    foreach ($datatrx as $row) :
                        $data = base64_encode($row['id'] . "*" . $row['id_menu']);
                ?>
                        <tr>
                            <td><?= $nomor; ?></td>
                            <td><?= $row['trx_date']; ?></td>
                            <td><?= ($row['nama_cabang'] == null || $row['nama_cabang'] == 0) ? "All" : $row['nama_cabang'] ?></td>
                            <td><?= $row['createby'] ?></td>
                            <td><?= $row['updateby'] ?></td>
                            <td><span class="badge <?= $row['type'] == "in" ? 'bg-success' : 'bg-danger' ?>"><?= $row['type'] == "in" ? 'Pemasukan' : 'Pengeluaran' ?></span></td>
                            <td><span class="badge <?= $row['cancelInd'] == "N" ? 'bg-success' : 'bg-danger' ?>"><?= $row['cancelInd'] == "N" ? 'Aktif' : 'Dibatalkan' ?></span></td>
                            <td align="right">
                                <?php if ($row['type'] == "in" && $row['cancelInd'] == "N") { ?>
                                    <button type="button" class="btn btn-danger" id="btn-cancel-trx-<?= $nomor ?>" data-id="<?= $row['id'] ?>" data-toggle="tooltip" data-placement="top" data-title="Batalkan Transaksi">
                                        <i class="fas fa-times "></i>
                                    </button>
                                    <a href="<?= base_url('owner/transaksi/generate/' . $row['id']) ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" data-title="Cetak Transaksi"><i class="fas fa-print "></i></a>
                                <?php } ?>
                                <?php if ($row['type'] == "out") { ?>
                                    <a href="<?= base_url('owner/transaksi/editPengeluaran/' . $data) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" data-title="Edit Transaksi"> <i class="fas fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($row['type'] == "in") { ?>
                                    <button type="button" class="btn btn-success" id="btn-dtl-trx-<?= $nomor ?>" data-id='<?= $row['id'] ?>' data-cabang="<?= ($row['nama_cabang'] == null || $row['nama_cabang'] == 0) ? "All" : $row['nama_cabang'] ?>" data-toggle="tooltip" data-placement="top" data-title="Detail Transaksi"><i class="fas fa-eye"></i></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $nomor++;
                    endforeach;
                } else { ?>
                    <td colspan="8" align="center">Nothing data found</td>
                <?php } ?>
            </tbody>
        </table>

        <div class="float-center">
        </div>
        <!-- /.card-footer-->
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<div class="modal fade" id="modaldtltrx" tabindex="-1" role="dialog" aria-labelledby="modaldtltrx" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaldtltrx">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <d class="tab-pane active" id="general">
                                <input type="hidden" name="type" value="in">
                                <div class="form-group">
                                    <label for="">Cabang</label>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <span id="cabang-text-dtl"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-10">
                                        <label for="">Menu</label>
                                    </div>
                                </div>
                                <div id="list-menu-group">
                                    <div id="list-menu-dtl">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <h6><b>Total Harga</b></h6>
                                        <h5 class="text-success" id="total-price-item-dtl"><b>Rp 0</b></h5>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

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
                        url: "<?= site_url('owner/transaksi/hapus/') ?>" + kode,
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
                url: "<?= site_url('owner/transaksi/formTambah') ?>",
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
        $('.tombolPengeluaran').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('owner/transaksi/formPengeluaran') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalTypeOut').on('show.bs.modal', function(e) {
                            $('#type').focus();

                        });
                        $('#modalTypeOut').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<script>
    var total = <?= count($datatrx) ?>;
    for (let index = 1; index <= total; index++) {

        $(`#btn-cancel-trx-${index}`).click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Perhatian',
                text: 'Apakah anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true
            }).then((resp) => {
                if (resp.value) {
                    $.ajax({
                        url: `<?= base_url('owner/transaksi/cancelTrx') ?>/${id}`,
                        success: function(response) {
                            var resp = JSON.parse(response)
                            if (resp.success) {
                                console.log("masuk success");
                                Swal.fire({
                                    title: "Berhasil",
                                    text: response.sukses,
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        console.log("masuk sini");
                                        window.location.reload();
                                    }
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    })
                }
            })
        });

        $(`#btn-dtl-trx-${index}`).click(function() {
            var id = $(this).data('id');
            var cabang = $(this).data('cabang');

            $.ajax({
                url: `<?= base_url('owner/transaksi/getDetailTransaksi') ?>/${id}`,
                success(resp) {
                    $("#list-menu-dtl").html("");
                    $("#cabang-text-dtl").html(cabang)
                    var totalPrice = 0;
                    for (const [i, e] of resp.entries()) {
                        var list = `<div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-4">
                              <h6><b>Nama Menu</b></h6>
                              <span>${e.nama_menu}</span>
                            </div>
                            <div class="col-sm-4">
                              <h6><b>Nominal</b></h6>
                              Rp ${Intl.NumberFormat('id-ID').format(e.harga)} <span class="text-success"><b>x ${e.quantity} Pcs</b></span>
                            </div>
                            <div class="col-sm-4">
                              <h6><b>Sub Total</b></h6>
                              <span>Rp ${Intl.NumberFormat('id-ID').format(e.sub_total)}</span>
                            </div>
                          </div>
                        </div>
                      </div>`

                        $("#list-menu-dtl").append(list);
                        $("#total-price-item-dtl").html(`Rp ${Intl.NumberFormat('id-ID').format(e.nominal)}`)
                    }

                    $("#modaldtltrx").modal('show');
                },
                error(err) {
                    console.log(err);
                }
            });

        });
    }
</script>

<?= $this->endsection() ?>
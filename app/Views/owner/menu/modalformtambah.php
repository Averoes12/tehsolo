<div class="modal fade" id="modaltambahmenu" tabindex="-1" role="dialog" aria-labelledby="modaltambahmenu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahmenu">Tambah menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('owner/menu/simpandata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama Menu</label>
                    <input type="text" name="namamenu" id="namamenu" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" name="hargamenu" id="hargamenu" class="form-control form-control-sm" min="1" required>
                </div>
                <div class="form-group">
                    <label for="">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control form-control-sm" min="0" required>
                </div>
                <div class="form-group">
                    <label for="">Cabang</label>
                    <select name="cabang" id="cabang" class="form-control select2">
                        <option value="">All</option>
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
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(e) {
                    $('.tombolSimpan').prop('disabled', true);
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
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
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
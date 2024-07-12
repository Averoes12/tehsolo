<div class="modal fade" id="modaltambahcabang" tabindex="-1" role="dialog" aria-labelledby="modaltambahcabang" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahcabang">Tambah cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('owner/cabang/simpandata', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="">Nama cabang</label>
                    <input type="text" name="namacabang" id="namacabang" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">ALamat</label>
                    <input type="text" name="alamatcabang" id="alamatcabang" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="">Telepon</label>
                    <input type="text" name="teleponcabang" id="teleponcabang" class="form-control form-control-sm" required>
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
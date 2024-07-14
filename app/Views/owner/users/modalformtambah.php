<div class="modal fade" id="modaltambahmenu" tabindex="-1" role="dialog" aria-labelledby="modaltambahmenu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahmenu">Tambah User</h5>
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
                    <select name="role" id="role" class="form-control select2">
                        <option value="owner">Owner</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Cabang</label>
                    <select name="cabang" id="cabang" class="form-control select2">
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

        $("#toggle-hint-password").click(function(){
            if($("#toggle-hint-password i").hasClass("fa-eye")){
                $("#toggle-hint-password i").removeClass("fa-eye");
                $("#toggle-hint-password i").addClass("fa-eye-slash");
                $("#password").attr("type", "password");
            }else {
                $("#toggle-hint-password i").removeClass("fa-eye-slash");
                $("#toggle-hint-password i").addClass("fa-eye");
                $("#password").attr("type", "text");
            }
        });
    });
</script>
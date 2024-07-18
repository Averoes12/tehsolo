<div class="modal fade" id="modalTypeOut" tabindex="-1" role="dialog" aria-labelledby="modalTypeOutLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTypeOutLabel">Catat Pengeluaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('owner/transaksi/simpandata', ['class' => 'formsimpan']) ?>
      <div class="modal-body">
        <input type="hidden" name="type" value="out">
        <div class="form-group">
          <label for="">Cabang</label>
          <select name="cabang" id="cabang" class="form-control select2 form-control-sm" required>
            <option value="">All</option>
            <?php foreach ($cabang as $e) { ?>
              <option value="<?= $e['id'] ?>"><?= $e['nama_cabang'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="barangOut">Barang</label>
          <input type="text" name="barang" id="barangOut" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
          <label for="">Harga</label>
          <input type="text" name="harga" id="hargaOut" class="form-control form-control-sm" min="1" pattern="[0-9]*" inputmode="numeric" required style="text-align: right;">
        </div>
        <div class="form-group">
          <label for="">Quantity</label>
          <input type="text" name="qty" id="qtyOut" class="form-control form-control-sm" pattern="[0-9]*" inputmode="numeric" min="1" required style="text-align: right;">
        </div>
        <div class="form-group">
          <label for="nominalOut">Nominal</label>
          <input type="number" name="nominal" id="nominalOut" class="form-control form-control-sm" min="1" readonly required style="text-align: right;">
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
    $('.select2').select2();

    $('.formsimpan').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.tombolSimpan').prop('disabled', true);
          $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        success: function(response) {
          if (response.sukses) {
            Swal.fire({
              title: "Berhasil",
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

    $("#qtyOut, #hargaOut").on("input keyup", function() {
      validateInput($(this));
      var harga = $("#hargaOut").val();
      var quantity = $("#qtyOut").val();
      if (harga && quantity) {
        var totalPrice = harga * quantity;
        $("#nominalOut").val(totalPrice);
      }
    });

    function validateInput(input) {
      var value = input.val();
      var sanitizedValue = value.replace(/[^0-9]/g, '');
      if (value !== sanitizedValue) {
        input.val(sanitizedValue);
      }
    }
  });
</script>
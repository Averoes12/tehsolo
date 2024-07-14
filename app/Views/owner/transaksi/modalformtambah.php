<div class="modal fade" id="modaltambahtrx" tabindex="-1" role="dialog" aria-labelledby="modaltambahtrx" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltambahtrx">Tambah Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('owner/transaksi/simpandata', ['class' => 'formsimpan']) ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="type">Type</label>
          <select name="type" id="type" class="form-control select2">
            <option value="in">In</option>
            <option value="out">Out</option>
          </select>
        </div>
        <div class="form-group">
          <label for="menu">Menu</label>
          <select name="menu" id="menu" class="form-control select2 form-control-sm" required>
            <option value="">-- Pilih Menu --</option>
            <?php foreach ($menu as $e) { ?>
              <option value="<?= $e['id'] ?>"><?= $e['nama_menu'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Harga</label>
          <input type="number" name="harga" id="harga" class="form-control form-control-sm" min="1" readonly required style="text-align: right;">
        </div>
        <div class="form-group">
          <label for="">Stok</label>
          <input type="number" name="stok" id="stok" class="form-control form-control-sm" readonly style="text-align: right;">
          <p id="info-stok" class="text-danger" style="text-align: right"></p>

        </div>
        <div class="form-group">
          <label for="">Quantity</label>
          <input type="number" name="qty" id="qty" class="form-control form-control-sm" min="1" required style="text-align: right;">
        </div>
        <div class="form-group">
          <label for="">Nominal</label>
          <input type="number" name="nominal" id="nominal" class="form-control form-control-sm" min="1" readonly required style="text-align: right;">
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

    $('#menu').select2();

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

    $("#menu").change(function() {
      var menuId = $(this).val();
      var type = $("#type").val();

      $.ajax({
        url: "<?= site_url('owner/transaksi/getMenuById/') ?>" + menuId,
        method: "GET",
        dataType: "json",
        success: function(data) {
          if (data.menu) {
            $("#harga").val(data.menu.harga);
            $("#stok").val(data.menu.stok);

            var quantity = $("#qty").val();
            if (quantity != "") {
              var totalPrice = data.menu.harga * quantity;
              $("#nominal").val(totalPrice);
            }

            if (type != "out") {

              if (data.menu.stok == 0) {
                $("#info-stok").html("Stok Habis");
                $(".tombolSimpan").prop("disabled", true);
              } else {

                $("#info-stok").html("");
                $(".tombolSimpan").prop("disabled", false);
              }
            }

          } else {
            alert("Menu tidak ditemukan");
          }
        },
        error: function(e) {
          alert("Terjadi kesalahan saat mengambil data menu");
        }
      });
    });

    $("#qty").on("input", function() {
      var harga = $("#harga").val();
      var stok = $("#stok").val();
      var quantity = $(this).val();
      var type = $("#type").val();

      if (harga != "") {
        var totalPrice = harga * quantity;
        $("#nominal").val(totalPrice);
      }

      if (type != "out") {
        if (stok == 0) {
          $("#info-stok").html("Stok habis");
          $(".tombolSimpan").prop("disabled", true);
        } else if (parseInt(quantity) > parseInt(stok)) {
          $("#info-stok").html("Stok tidak mencukupi");
          $(".tombolSimpan").prop("disabled", true);

        } else {
          $("#info-stok").html("");
          $(".tombolSimpan").prop("disabled", false);
        }
      }

    });
  });
</script>
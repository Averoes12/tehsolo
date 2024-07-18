<?= $this->extend('owner/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit Transaksi</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('owner/transaksi') ?>">Daftar Transaksi</a></li>
<li class="breadcrumb-item active">Edit Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card">
  <div class="card-header">
    <form method="POST" action="<?= base_url('owner/transaksi/update/' . $trx['id']) ?>">
      <div class="card-body">
        <input type="hidden" name="old_qty" value="<?= $trx['quantity'] ?>">
        <div class="form-group">
          <label for="type">Type</label>
          <input type="hidden" name="type" value="in">
        </div>
        <div class="form-group" id="cabang-group">
          <label for="">Cabang</label>
          <select name="cabang" id="cabang" class="form-control select2 form-control-sm" required>
            <option value="">All</option>
            <?php foreach ($cabang as $e) { ?>
              <option value="<?= $e['id'] ?>" <?= $e['id'] == $trx['id_cabang'] ? 'selected' : '' ?>>
                <?= $e['nama_cabang'] ?>
              </option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group" id="menu-group">
          <label>Nama Menu</label>
          <select name="menu" id="menu" class="form-control select2 form-control-sm <?= ($validation->hasError('nama_menu')) ? 'is-invalid' : '' ?>">
            <?php foreach ($menus as $e) : ?>
              <option value="<?= $e['id'] ?>" <?= $e['id'] == $trx['id_menu'] ? 'selected' : '' ?>>
                <?= $e['nama_menu'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <?php if ($validation->hasError('nama_menu')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('nama_menu') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group" id="barang-group" style="display:none;">
          <label for="barang">Barang</label>
          <input type="text" name="barang" id="barang" class="form-control <?= ($validation->hasError('barang')) ? 'is-invalid' : '' ?>" value="<?= $trx['barang'] ?>">
          <?php if ($validation->hasError('barang')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('barang') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Harga</label>
          <input type="text" id="harga" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" name="harga" pattern="[0-9]*" inputmode="numeric" value="<?= $menu['harga'] ?>" <?= $trx['type'] == 'in' ? 'readonly' : '' ?>>
          <?php if ($validation->hasError('harga')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('harga') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group" id="stok-group">
          <label>Stok</label>
          <input type="text" id="stok" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : '' ?>" name="stok" pattern="[0-9]*" inputmode="numeric" value="<?= $menu['stok'] ?>" readonly>
          <p id="info-stok" class="text-danger" style="text-align: right"></p>
          <?php if ($validation->hasError('stok')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('stok') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input type="text" id="qty" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : '' ?>" name="qty" pattern="[0-9]*" inputmode="numeric" value="<?= $trx['quantity'] ?>">
          <?php if ($validation->hasError('qty')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('qty') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Nominal</label>
          <input type="text" id="nominal" class="form-control <?= ($validation->hasError('nominal')) ? 'is-invalid' : '' ?>" name="nominal" pattern="[0-9]*" inputmode="numeric" value="<?= $trx['nominal'] ?>" readonly>
          <?php if ($validation->hasError('nominal')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('nominal') ?>
            </div>
          <?php endif; ?>
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary tombolSimpan">Submit</button>
      </div>
    </form>
  </div>
</div>

<?php if (session()->getFlashdata('toast') == 'success') : ?>
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
    // Initialize fields based on current type
    function updateFieldsBasedOnType(type) {

      // Show/hide fields based on type
      if (type === "out") {
        $("#menu-group").hide();
        $("#barang-group").show();
        $("#harga").prop("readonly", false);
        $("#stok-group").hide();
      } else {
        $("#menu-group").show();
        $("#barang-group").hide();
        $("#harga").prop("readonly", true);
        $("#stok-group").show();
      }
    }

    // Handle type change
    $("#type").change(function() {
      var type = $(this).val();
      updateFieldsBasedOnType(type);
    });

    // Initialize fields based on current type
    var currentType = $("#type").val();
    updateFieldsBasedOnType(currentType);

    // Handle menu change
    $("#menu").change(function() {
      var menuId = $(this).val();
      var quantity = $("#qty").val();
      var type = $("#type").val();

      $.ajax({
        url: "<?= site_url('owner/transaksi/getMenuById/') ?>" + menuId,
        method: "GET",
        dataType: "json",
        success: function(data) {
          if (data.menu) {
            $("#harga").val(data.menu.harga);
            $("#stok").val(data.menu.stok);

            if (quantity != "") {
              var totalPrice = data.menu.harga * parseInt(quantity);
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

    function validateInput(input) {
      var value = input.val();
      var sanitizedValue = value.replace(/[^0-9]/g, '');

      if (value !== sanitizedValue) {
        input.val(sanitizedValue);
      }
    }

    $("#qty, #harga, #stok").on("input keyup", function() {
      validateInput($(this));

      var harga = $("#harga").val();
      var stok = $("#stok").val();
      var quantity = $("#qty").val();
      var type = $("#type").val();

      if (harga != "" && quantity != "") {
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

    // Initial validation
    $("#qty, #harga, #stok").trigger("keyup");
  });
</script>

<?= $this->endsection() ?>
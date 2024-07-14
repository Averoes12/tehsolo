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
        <div class="form-group">
          <label for="type">Type</label>
          <select name="type" id="type" class="form-control select2 <?= ($validation->hasError('id_cabang')) ? 'is-invalid' : '' ?>">
            <option value="out" <?= "out" == $trx['type'] ? 'selected' : '' ?>>Out</option>
            <option value="in" <?= "in" == $trx['type'] ? 'selected' : '' ?>>In</option>
          </select>
          <?php if ($validation->hasError('type')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('type') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Nama Menu</label>
          <select name="menu" id="menu" class="form-control select2 <?= ($validation->hasError('nama_menu')) ? 'is-invalid' : '' ?>">
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
        <div class="form-group">
          <label>Harga</label>
          <input type="number" min="1" id="harga" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" name="harga" placeholder="Harga" value="<?= $menu['harga'] ?>" readonly>
          <?php if ($validation->hasError('harga')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('harga') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Stok</label>
          <input type="number" min="0" id="stok" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : '' ?>" name="stok" placeholder="Stok" value="<?= $menu['stok'] ?>" readonly>
          <p id="info-stok" class="text-danger" style="text-align: right"></p>
          <?php if ($validation->hasError('stok')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('stok') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input type="number" min="0" id="qty" class="form-control <?= ($validation->hasError('quantity')) ? 'is-invalid' : '' ?>" name="qty" placeholder="Quantity" value="<?= $trx['quantity'] ?>">
          <?php if ($validation->hasError('quantity')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('quantity') ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>Nominal</label>
          <input type="number" min="0" id="nominal" class="form-control <?= ($validation->hasError('nominal')) ? 'is-invalid' : '' ?>" name="nominal" placeholder="Nominal" value="<?= $trx['nominal'] ?>" readonly>
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
</script>

<?= $this->endsection() ?>
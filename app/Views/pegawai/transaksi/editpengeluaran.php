<?= $this->extend('pegawai/nav') ?>

<?= $this->section('judul') ?>
<h3>Edit Transaksi</h3>
<?= $this->endsection() ?>

<?= $this->section('breadcumb-active') ?>
<li class="breadcrumb-item"><a href="<?= site_url('pegawai/transaksi') ?>">Daftar Transaksi</a></li>
<li class="breadcrumb-item active">Edit Transaksi</li>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<div class="card">
  <div class="card-header">
    <form method="POST" action="<?= base_url('pegawai/transaksi/update/' . $trx['id']) ?>">
      <div class="card-body">
        <div class="form-group">
          <label for="type">Type</label>
          <input type="hidden" name="type" value="out">
        </div>
        <div class="form-group" id="barang-group">
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
          <input type="text" id="harga" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" name="harga" pattern="[0-9]*" inputmode="numeric" value="<?= ($trx['nominal'] / $trx['quantity']) ?>" <?= $trx['type'] == 'in' ? 'readonly' : '' ?>>
          <?php if ($validation->hasError('harga')) : ?>
            <div class="invalid-feedback">
              <?= $validation->getError('harga') ?>
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
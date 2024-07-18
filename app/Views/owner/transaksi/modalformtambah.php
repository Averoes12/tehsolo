<div class="modal fade" id="modaltambahtrx" tabindex="-1" role="dialog" aria-labelledby="modaltambahtrx" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltambahtrx">Tambah Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('owner/transaksi/simpandata', ['class' => 'formsimpan']) ?>
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
                      <input type="hidden" name="cabang" id="cabang-value" value="-1">
                      <span id="cabang-text">Silahkan pilih cabang terlebih dahulu</span>
                    </div>
                    <div class="col-sm-2 text-right">
                      <button type="button" class="btn btn-outline-primary" id="btn-show-cabang">Pilih Cabang</button>
                    </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-10">
                    <label for="">Menu</label>
                  </div>
                  <div class="col-sm-2 text-right">
                    <button type="button" class="btn btn-primary" id="add-item">Tambah Menu</button>
                  </div>
                </div>
                <div id="list-menu-group">
                  <div id="empty-menu-state">
                    <h6>Belum ada menu, silahkan tambah menu terlebih dahulu</h6>
                  </div>
                  <div id="list-menu">

                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 text-right">
                    <h6><b>Total Harga</b></h6>
                    <input type="hidden" name="" id="total-price-value">
                    <h5 class="text-success" id="total-price-item"><b>Rp 0</b></h5>
                  </div>
                </div>
            </div>
          </div>
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

<div class="modal fade" id="modal-add-item" role="dialog" aria-labelledby="modal-add-item" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-add-item">Tambah Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="in">
        <div class="form-group">
          <label for="menu">Menu</label>
          <select name="menu" id="menu" class="form-control select2 form-control-sm" required>
            <option value="">-- Pilih Menu --</option>

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
          <input type="text" name="qty" id="qty" class="form-control form-control-sm" pattern="[0-9]*" inputmode="numeric" min="1" required style="text-align: right;">
        </div>
        <div class="form-group">
          <label for="">Nominal</label>
          <input type="number" name="nominal" id="nominal" class="form-control form-control-sm" min="1" readonly required style="text-align: right;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save-item">Tambah</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-add-cabang" role="dialog" aria-labelledby="modal-add-item" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-add-item">Pilih Cabang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="item-card-cabang">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- show modal cabang -->
<script>
  $("#btn-show-cabang").click(function() {

    if (listMenu.length != 0) {
      Swal.fire({
        title: "Perhatian",
        text: "Semua menu yang sudah ditambah akan hilang, anda yakin ?",
        icon: "warning",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
        showCancelButton: true,
      }).then((result) => {
        console.log(result);
        if (result.value) {
          $("#list-menu").html("");
          listMenu.length = 0;
          $("#empty-menu-state").prop("hidden", false);
          $("#total-price-item").html("<b>Rp 0</b>");
          $("#total-price-value").val("");

          $("#modal-add-cabang").modal('show');

        }
      });
    } else {
      $("#modal-add-cabang").modal('show');

    }

    $("#item-card-cabang").html("");
    $.ajax({
      url: "<?= site_url('owner/transaksi/getAllCabang') ?>",
      method: "get",
      success(resp) {
        $("#item-card-cabang").append(`
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-10">
                  <input id="id-cabang" type="hidden" value="0*All">
                  <span>All</span>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary" id="btn-select-cabang0">Pilih</button>
                </div>
              </div>
            </div>
          </div>`);
        $(`#btn-select-cabang0`).click(function() {
          $("#cabang-value").html("");
          $("#cabang-value").val("");

          $("#cabang-text").html("All");
          $("#cabang-value").val("0");

          $("#modal-add-cabang").modal('hide');
          $("#btn-show-cabang").html("Ganti Cabang");
          $("#btn-show-cabang").removeClass("btn-outline-primary");
          $("#btn-show-cabang").addClass("btn-outline-warning");
        })
        for (const [i, e] of resp.entries()) {
          var list = `
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-10">
                  <input id="id-cabang" type="hidden" value="${e.id}*${e.nama_cabang}">
                  <span>${e.nama_cabang}</span>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary" id="btn-select-cabang${e.id}">Pilih</button>
                </div>
              </div>
            </div>
          </div>`;

          $("#item-card-cabang").append(list);

          $(`#btn-select-cabang${e.id}`).click(function() {
            $("#cabang-value").html("");
            $("#cabang-value").val("");

            $("#cabang-text").html(e.nama_cabang);
            $("#cabang-value").val(e.id);

            $("#modal-add-cabang").modal('hide');
          })
        }
      },
      error(e) {
        $("#item-card-cabang").html("<span>Sedang terjadi gangguan, silahkan coba nanti</span>");
      }
    });
  });
</script>
<!-- get menu by cabang -->
<script>
  var listMenu = [];

  $("#add-item").click(function() {

    var idCabang = $("#cabang-value").val();

    if (idCabang == -1) {
      Swal.fire({
        title: "warning",
        text: 'Silahkan pilih cabang terlebih dahulu',
        icon: "warning"
      })
    } else {

      $.ajax({
        url: "<?= site_url('owner/transaksi/getMenuByCabang') ?>",
        type: 'GET',
        data: {
          id: idCabang
        },
        dataType: 'json',
        success: function(response) {
          $('#menu').empty();
          $("#harga").val("");
          $("#stok").val("");
          $("#nominal").val("");
          $("#qty").val("");
          $("#info-stok").html("");


          $('#menu').append('<option value="">-- Pilih Menu --</option>');

          $.each(response, function(key, value) {
            $('#menu').append('<option value="' + value.id + '*' + value.nama_menu + '">' + value.nama_menu + '</option>');
          });
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error:', status, error);
        }
      });

      $("#modal-add-item").modal('show');
    }


  });
</script>
<!-- save add menu -->
<script>
  $(".btn-save-item").click(function() {
    var separate = $("#menu").val().split("*");
    var id = separate[0];
    var name = separate[1];
    var harga = $("#harga").val();
    var qty = $("#qty").val();
    var nominal = $("#nominal").val();

    if(qty != "" && qty != 0 && separate != ""){

      var data = {
        "id": id,
        "name": name,
        "harga": harga,
        "qty": qty,
        "nominal": nominal
      }
  
      listMenu.push(data);
  
      $("#list-menu").html("");
      $("#empty-menu-state").prop('hidden', true);
  
      var totalPrice = 0;
      for (const [i, e] of listMenu.entries()) {
        var list = `<div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-4">
                              <h6><b>Nama Menu</b></h6>
                              <span>${e['name']}</span>
                            </div>
                            <div class="col-sm-4">
                              <h6><b>Nominal</b></h6>
                              Rp ${Intl.NumberFormat('id-ID').format(e['harga'])} <span class="text-success"><b>x ${e['qty']} Pcs</b></span>
                            </div>
                            <div class="col-sm-4">
                              <h6><b>Sub Total</b></h6>
                              <span>Rp ${Intl.NumberFormat('id-ID').format(e['nominal'])}</span>
                            </div>
                          </div>
                        </div>
                      </div>`
  
        $("#list-menu").append(list);
  
        totalPrice += parseInt(e['nominal']);
        $("#total-price-item").html(`<b>Rp ${Intl.NumberFormat('id-ID').format(totalPrice)}</b>`)
        $("#total-price-value").val(totalPrice);
      }
  
      $("#modal-add-item").modal('hide');
    } else {
      Swal.fire({
        title: "Perhatian",
        text: 'Harap isi semua field',
        icon: 'warning'
      })
    }

  });
</script>
<!-- submit data -->
<script>
  $(document).ready(function() {

    $('.select2').select2();

    $('.formsimpan').submit(function(e) {
      e.preventDefault();

      if(listMenu.length > 0){
        var data = {
          'cabang' : $("#cabang-value").val(),
          'nominal': $("#total-price-value").val(),
          'menus':listMenu,
          'type': 'in'
        }
        $.ajax({
          type: "post",
          url: $(this).attr('action'),
          data: data,
          dataType: "json",
          beforeSend: function(e) {
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
        });
      } else {
        Swal.fire({
          title: "Perhatian",
          text: "Harap lengkapi data",
          icon: 'warning'
        });
      }

    });

    $("#menu").change(function() {
      var menuId = $(this).val();
      var type = $("#type").val();
      $("#harga").val("");
      $("#stok").val("");
      $("#nominal").val("");
      $("#qty").val("");
      $("#info-stok").html("");

      if (menuId != "") {

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
      }
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
          $(".btn-save-item").prop("disabled", true);
        } else if (parseInt(quantity) > parseInt(stok)) {
          $("#info-stok").html("Stok tidak mencukupi");
          $(".btn-save-item").prop("disabled", true);
        } else {
          $("#info-stok").html("");
          $(".btn-save-item").prop("disabled", false);
        }
      }
    });
  });
</script>
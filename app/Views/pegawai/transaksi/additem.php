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
    });

    $("#menu").change(function() {
      var menuId = $(this).val();
      var type = $("#type").val();

      if (menuId != "") {

        $.ajax({
          url: "<?= site_url('pegawai/transaksi/getMenuById/') ?>" + menuId,
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
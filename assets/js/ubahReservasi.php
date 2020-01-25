<script type="text/javascript">
  function hitung2(){
    <?php $no_res = 1 ?> //query reservasi
    <?php foreach ($sql as $key): ?>
      var JmlHarii_<?=$no_res;?> = Number($('#jumlahHarii_<?=$no_res;?>').val());
      var TotHargaa_<?=$no_res;?>=0;
      var TotKamarr_<?=$no_res;?>=0;
      <?php $i = 1; ?> //query kamar
      <?php foreach ($queKamar as $key): ?>

        var JmlKamarr_<?=$no_res;?><?=$i;?> = Number($('#Kamarr<?=$no_res;?><?=$i;?>').val());
        var hargaKamar_tipee_<?=$no_res;?><?=$i;?> = Number($('#hargaPerKamarr<?=$no_res;?><?=$i;?>').val());

        TotHargaa_<?=$no_res;?> = TotHargaa_<?=$no_res;?>+(JmlKamarr_<?=$no_res;?><?=$i;?> * hargaKamar_tipee_<?=$no_res;?><?=$i;?>);

        TotKamarr_<?=$no_res;?> = TotKamarr_<?=$no_res;?>+JmlKamarr_<?=$no_res;?><?=$i;?>;

        if ($('#Kamarr<?=$no_res;?><?=$i?>').val() == 0) {
          document.getElementById("btnKamarr_<?=$no_res;?><?=$i?>").checked = false;
          document.getElementById("Kamarr<?=$no_res;?><?=$i?>").disabled = true;
        };
      
      var total_Hargaa_<?=$no_res;?> = TotHargaa_<?=$no_res;?> * JmlHarii_<?=$no_res;?>;
      $('#total_hargaa_<?=$no_res;?>').val(formatRupiah(total_Hargaa_<?=$no_res;?>,' '));
      $('#total_harga_duplicate2_<?=$no_res;?>').val(formatRupiah(total_Hargaa_<?=$no_res;?>,' '));
      $('#jmlKamarr_<?=$no_res;?>').val(TotKamarr_<?=$no_res;?>);
      <?php ++$i; ?>
      <?php endforeach; ?>
    <?php ++$no_res ?>
    <?php endforeach; ?>
  };
  <?php $no_res = 1; ?>
  <?php foreach ($sql as $key): ?>
    <?php $i = 1; ?>
    <?php foreach ($queKamar as $key): ?>          
      var checkboxess<?=$no_res;?><?=$i;?> = $("#btnKamarr_<?=$no_res;?><?=$i;?>"),
      submitButtt<?=$no_res;?><?=$i;?> = $("#Kamarr<?=$no_res;?><?=$i;?>");
      checkboxess<?=$no_res;?><?=$i;?>.click(function() {
        submitButtt<?=$no_res;?><?=$i;?>.attr("disabled", !checkboxess<?=$no_res;?><?=$i;?>.is(":checked"));
      });
      checkboxess<?=$no_res;?><?=$i;?>.change(function() {
        if (checkboxess<?=$no_res;?><?=$i;?>.is(":checked")) {
          document.getElementById('Kamarr<?=$no_res;?><?=$i;?>').value = 1;
        } else 
          document.getElementById('Kamarr<?=$no_res;?><?=$i;?>').value = 0;
      });
    <?php ++$i; ?>
    <?php endforeach; ?>
    <?php ++$no_res; ?>
  <?php endforeach ?>

  function disableButtonPesan2() {
    <?php $no_res = 1; ?>
    <?php foreach ($sql as $key): ?>
      var str_<?=$no_res;?>, element_<?=$no_res;?> = document.getElementById('total_hargaa_<?=$no_res;?>');
      if (element_<?=$no_res;?> != null) {
        str_<?=$no_res;?> = element_<?=$no_res;?>.value;
        if (str_<?=$no_res;?> <= 0 ) {
          $('#btnPesan_reservasii_<?=$no_res;?>').attr("disabled","disabled");
        }
        else {
          $('#btnPesan_reservasii_<?=$no_res;?>').removeAttr("disabled","disabled");
        }
      }
      else {
        str_<?=$no_res;?> = null;
      }
    <?php ++$no_res; ?>
    <?php endforeach ?>
  };
  function disableCheck2() {
    <?php $no_res = 1; ?>
    <?php foreach ($sql as $key): ?>
      if($('#TMM_<?=$no_res;?>').val()==='' || $('#TKK_<?=$no_res;?>').val()===''){
        <?php $i=1; ?>
        <?php foreach ($queKamar as $val): ?>
          $('#btnKamarr_<?=$no_res;?><?=$i;?>').prop('disabled', true);
        <?php ++$i; ?>
        <?php endforeach ?>
      }else{
        <?php $i=1; ?>
        <?php foreach ($queKamar as $val): ?>
          $('#btnKamarr_<?=$no_res;?><?=$i;?>').prop('disabled', false);
        <?php ++$i; ?>
        <?php endforeach ?>
      }
    <?php ++$no_res; ?>
    <?php endforeach ?>
  }
  // DatePick
  <?php $no_res=1; ?>
  <?php foreach ($sql as $key): ?>
    $('#TMM_<?=$no_res;?>').datepicker({
      minDate : 0,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });
    $('#TKK_<?=$no_res;?>').datepicker({
      minDate : 0,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });
    $('#TMM_<?=$no_res;?>').datepicker().bind("change", function () {
      var minValuee_<?=$no_res;?> = $(this).val();
      minValuee_<?=$no_res;?> = $.datepicker.parseDate("dd-mm-yy", minValuee_<?=$no_res;?>);
      $('#TKK_<?=$no_res;?>').datepicker("option", "minDate_<?=$no_res;?>", minValuee_<?=$no_res;?>);
      calculate2();
    });
    $('#TKK_<?=$no_res;?>').datepicker().bind("change", function () {
      var maxValuee_<?=$no_res;?> = $(this).val();
      maxValuee_<?=$no_res;?> = $.datepicker.parseDate("dd-mm-yy", maxValuee_<?=$no_res;?>);
      $('#TMM_<?=$no_res;?>').datepicker("option", "maxDate_<?=$no_res;?>", maxValuee_<?=$no_res;?>);
      calculate2();
    });
  <?php ++$no_res; ?>
  <?php endforeach ?>
  function calculate2() {
    <?php $no_res=1; ?>
    <?php foreach ($sql as $key): ?>
      var d11_<?=$no_res;?> = $('#TMM_<?=$no_res;?>').datepicker('getDate');
      var d21_<?=$no_res;?> = $('#TKK_<?=$no_res;?>').datepicker('getDate');
      var oneDayy_<?=$no_res;?> = 24*60*60*1000;
      var difff_<?=$no_res;?> = 0;
      if (d11_<?=$no_res;?> && d21_<?=$no_res;?>) {
        difff_<?=$no_res;?> = Math.round(Math.abs((d21_<?=$no_res;?>.getTime() - d11_<?=$no_res;?>.getTime())/(oneDayy_<?=$no_res;?>)));
      }
      $('#jumlahHarii_<?=$no_res;?>').val(difff_<?=$no_res;?>);
    <?php ++$no_res; ?>
    <?php endforeach ?>
  };
</script>
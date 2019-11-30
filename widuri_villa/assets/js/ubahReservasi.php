<script type="text/javascript">
  function hitung2(){
    var JmlHarii = Number($('#jumlahHarii').val());
    var TotHargaa=0;
    var TotKamarr=0;
    <?php $i = 1; ?>
    <?php foreach ($queKamar as $key): ?>
      var JmlKamarr<?=$i;?> = Number($('#Kamarr<?=$i;?>').val());
      var hargaKamar_tipee<?=$i;?> = Number($('#hargaPerKamarr<?=$i;?>').val());
      TotHargaa = TotHargaa+(JmlKamarr<?=$i;?> * hargaKamar_tipee<?=$i;?>);
      TotKamarr = TotKamarr+JmlKamarr<?=$i;?>;
      if ($('#Kamarr<?=$i?>').val() == 0) {
        document.getElementById("btnKamarr_<?=$i?>").checked = false;
        document.getElementById("Kamarr<?=$i?>").disabled = true;
      };
    <?php ++$i; ?>
    <?php endforeach; ?>
    var total_Hargaa = TotHargaa * JmlHarii;
    $('#total_hargaa').val(formatRupiah(total_Hargaa,' '));
    $('#jmlKamarr').val(TotKamarr);
  };
  <?php $i = 1; ?>
  <?php foreach ($queKamar as $key): ?>          
    var checkboxess<?=$i;?> = $("#btnKamarr_<?=$i;?>"),
    submitButtt<?=$i;?> = $("#Kamarr<?=$i;?>");
    checkboxess<?=$i;?>.click(function() {
      submitButtt<?=$i;?>.attr("disabled", !checkboxess<?=$i;?>.is(":checked"));
    });
    checkboxess<?=$i;?>.change(function() {
      if (checkboxess<?=$i;?>.is(":checked")) {
        document.getElementById('Kamarr<?=$i?>').value = 1;
      } else 
        document.getElementById('Kamarr<?=$i?>').value = 0;
    });
  <?php ++$i; ?>
  <?php endforeach; ?>
  function disableButtonPesan2() {
    var ttHargaa = document.getElementById('total_hargaa');
    if (ttHargaa.value === "0") {
      $('#btnPesan_reservasii').attr("disabled","disabled");
    }else{
      $('#btnPesan_reservasii').removeAttr("disabled","disabled");
    }
  };
  function disableCheck2() {
    if($('#TMM').val()==='' || $('#TKK').val()===''){
      $('.checkbox-custom input[type=checkbox]').prop('disabled', true);
    }else{
      $('.checkbox-custom input[type=checkbox]').prop('disabled', false);
    }
  }
  // DatePick
  $('#TMM').datepicker({
    minDate : 0,
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
  });
  $('#TKK').datepicker({
    minDate : 0,
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
  });
  $('#TMM').datepicker().bind("change", function () {
    var minValuee = $(this).val();
    minValuee = $.datepicker.parseDate("dd-mm-yy", minValuee);
    $('#TKK').datepicker("option", "minDate", minValuee);
    calculate();
  });
  $('#TKK').datepicker().bind("change", function () {
    var maxValuee = $(this).val();
    maxValuee = $.datepicker.parseDate("dd-mm-yy", maxValuee);
    $('#TMM').datepicker("option", "maxDate", maxValuee);
    calculate();
  });
  function calculate2() {
    var d11 = $('#TMM').datepicker('getDate');
    var d21 = $('#TKK').datepicker('getDate');
    var oneDayy = 24*60*60*1000;
    var difff = 0;
    if (d11 && d21) {
      difff = Math.round(Math.abs((d21.getTime() - d11.getTime())/(oneDayy)));
    }
    $('#jumlahHarii').val(difff);
  };
</script>
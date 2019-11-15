<?php 
session_start();
	// if (isset($_POST["submit"])) {
 //    $id_kamar = $_SESSION['pilihanKamar']['tipeKamarTerpilih'];
 //    require '../koneksi/function_global.php';
	// foreach ($id_kamar as $key) {
 //        $query = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE id_tipe_kamar = ".$key."");
 //    }
	// // }
 //    if (isset($_SESSION["pilihanKamar"])) {
 //        echo "<br/>";
 //        foreach (array_combine($_SESSION["pilihanKamar"]["tipeKamarTerpilih"], $_SESSION["pilihanKamar"]["jumlahKamarTerpilih"]) as $value => $JmlKamar) {
 //            echo "Anda memilih kamar ".$value." dengan jumlah kamar ".$JmlKamar."</br>";
 //        }
 //    }

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>asd</title>
    <link rel="shortcut icon" href="../assets/images/logo-w.png">
    
    <link rel="stylesheet" href="../assets/css/style.css">  
</head>
<body>
    
    <form action="" method="post">
        <input type="number" name="a" class="input1" onkeyup="hit()">
        <input type="number" name="b" class="input2" onkeyup="hit()">
        <button type="submit" name="c" >PROSES</button>
    </form>
        <input type="text" name="d" class="output">
    

	
<script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    
    <script type="text/javascript">
        function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split       = number_string.split(','),
        sisa        = split[0].length % 3,
        rupiah        = split[0].substr(0, sisa),
        ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
        if(ribuan){
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
      };
      // $('.output').on('keyup', function () {
      //   $('.output').val(formatRupiah());
      // });
      function hit() {
        var out = 0;
        var in1 = Number($('.input1').val());
        var in2 = Number($('.input2').val());
        out = (in1 + in2);
        $('.output').val(formatRupiah(out));
      }
    </script>
    <!--  <script type="text/javascript">
     	function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        var imgId = '#preview-'+$(input).attr('id');
        $(imgId).attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
  $("form input[type='file']").change(function(){
    readURL(this);
  });
     </script> -->
</body>
</html>

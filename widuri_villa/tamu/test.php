<?php 
session_start();
	// if (isset($_POST["submit"])) {
		
	// }

	$tglCI = $_SESSION["pilihanKamar"]["tglCheckin"];
	  $tglCO =  $_SESSION["pilihanKamar"]["tglCheckout"];
	  $jmlHari = $_SESSION["pilihanKamar"]["jml_hari"];
	  $adlt = $_SESSION["pilihanKamar"]["adt"];
	  $cild = $_SESSION["pilihanKamar"]["cld"];

  echo "$tglCI,
		$tglCO,
		$jmlHari,
		$adlt,
		$cild";
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>asd</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" >
    Imagine 1:<br>
     <input type="file" name="img1" id="img1"><br>
     <img id="preview-img1" />
         <br><br>     
    Imagine 2 :<br>
     <input type="file" name="img2" id="img2"><br>
     <img id="preview-img2" />
         <br>
     Imagine 3 :<br>
     <input type="file" name="img3" id="img3"><br>
     <img id="preview-img3" /> 
         <br>
     Imagine 4 :<br>
     <input type="file" name="img4" id="img4"><br>
     <img id="preview-img4" />     
         <br>
     Imagine 5 :<br>
     <input type="file" name="img5" id="img5"><br>
     <img id="preview-img5" />     
         <br>
     Imagine 6 :<br>
     <input type="file" name="img6" id="img6"><br>
     <img id="preview-img6" />     
         <br>
     Imagine 7 :<br>
     <input type="file" name="img7" id="img7"><br>
     <img id="preview-img7" />     
         <br>
     Imagine 8 :<br>
     <input type="file" name="img8" id="img8"><br>
     <img id="preview-img8" />     
         <br>
     Imagine 9 :<br>
     <input type="file" name="img9" id="img9"><br>
     <img id="preview-img9" />     
         <br>
     Imagine 10 :<br>
     <input type="file" name="img10" id="img10"><br>
     <img id="preview-img10" />     
         <br>
     Imagine 11 :<br>
     <input type="file" name="img11" id="img11"><br>
     <img id="preview-img11" />     
         <br>
     Imagine 12 :<br>
     <input type="file" name="img12" id="img12"><br>
     <img id="preview-img12" />     
         <br>
     Imagine 13 :<br>
     <input type="file" name="img13" id="img13"><br>
     <img id="preview-img13" />     
         <br>
     Imagine 14 :<br>
     <input type="file" name="img14" id="img14"><br>
     <img id="preview-img14" />     
         <br>
     Imagine 15 :<br>
     <textarea id="insert" name="content"></textarea>
     <input type="file" name="img15" id="img15"><br>
      <img id="preview-img15" />    
     </form>
     
     <form method="post" enctype="multipart/form-data" >
     
       <input type="file" name="img16" id="img16"><br>
       <img id="preview-img16" />     
         <br>
     Imagine 15 :<br>
     
     </form>
<script type="text/javascript" src="../assets-2/js/jquery-3.3.1.js"></script>
     <script type="text/javascript">
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
     </script>
</body>
</html>

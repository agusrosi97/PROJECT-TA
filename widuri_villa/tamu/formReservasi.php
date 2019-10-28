<div class="col-lg-4 ftco-animate">
  <div class="card border p-4 mb-2 shadow-sm">
  	<h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>

    <form id="form_reservasi" action="" method="POST">

    	<input type="hidden" name="nama_Kamar" value="Tipe Satu">
    	<input type="hidden" name="jumlah_Kamar" value="1">
    	<input type="hidden" name="tipe_Kamar" value="1">

			<div class="form-group">
				<label for="tgl_c1">Checkin</label>
				<input type="date" id="TM" class="form-control txtDate inputangka" value="<?php echo $tglCI ?>" onchange="hitungHari()" name="inpCekIn">
			</div>

			<div class="form-group">
				<label for="tgl_co">Checkout</label>
				<input type="date" id="TK" class="form-control txtDate inputangka" value="<?php echo $tglCO ?>" onchange="hitungHari()" name="inpCekOut">
			</div>

			<div class="form-group">
				<label for="jml_adlt">Dewasa</label>
				<select id="jml_adlt" name="org_dewasa" class="form-control" required>
					<option value="0">Adult</option>
					<option <?php if ($adlt == "1" ) echo 'selected' ; ?> value="1">1</option>
					<option <?php if ($adlt == "2" ) echo 'selected' ; ?> value="2">2</option>
					<option <?php if ($adlt == "3" ) echo 'selected' ; ?> value="3">3</option>
					<option <?php if ($adlt == "4" ) echo 'selected' ; ?> value="4">4</option>
					<option <?php if ($adlt == "5" ) echo 'selected' ; ?> value="5">5</option>
				</select>
			</div>

			<div class="form-group">
				<label for="jml_ank">Anak-anak</label>
				<select name="anak" id="jml_ank" class="form-control">
					<option value="0">Children</option>
					<option <?php if ($cild == "1" ) echo 'selected' ; ?> value="1">1</option>
					<option <?php if ($cild == "2" ) echo 'selected' ; ?> value="2">2</option>
					<option <?php if ($cild == "3" ) echo 'selected' ; ?> value="3">3</option>
					<option <?php if ($cild == "4" ) echo 'selected' ; ?> value="4">4</option>
					<option <?php if ($cild == "5" ) echo 'selected' ; ?> value="5">5</option>
				</select>
			</div>

			<div class="form-group">
				<label>Jumlah hari</label>
				<input type="text" id="jumlahHari" name="total_tanggal" value="<?php echo "$jmlHari" ?>" class="form-control inputangka" readonly>
			</div>

			<div class="form-group">
        <label for="total_harga" style="font-size: 20px">Total</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-light">Rp</span>
          </div>
          <input type="text" class="form-control" id="total_harga" readonly style="font-weight: bold; font-size: 20px" name="total_harga" <?php if (!empty($_SESSION["pilihanKamar"]["total_harga"])) :?> value="<?php echo $total_harga ?>"<?php else: ?><?php endif; ?>>
        </div>
      </div>

			<div class="col text-center">
				<!-- <button type="submit" id="btnPesan_reservasi" class="btn btn-primary shadow-sm" name="submit" disabled>Lanjut ke pembayaran</button> -->
				<!-- <a href="verify/login.php" class="btn btn-secondary">Sementara</a> -->
				<button class="btn btn-primary rounded shadow-sm" type="submit" name="submitPesanan">Lanjut ke pembayaran</button>
			</div>
		</form>
  </div>
</div>
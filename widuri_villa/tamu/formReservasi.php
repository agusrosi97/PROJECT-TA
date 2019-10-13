					<div class="col-md-4 ftco-animate">
            <div class="card border p-4 mb-2 shadow-sm">
            	<h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>
              <form id="form_reservasi" action="" method="POST">
								<div class="form-group">
									<label for="tgl_c1">Checkin</label>
									<input type="date" id="TM" class="form-control txtDate" value="<?php echo $ci ?>" onchange="hitungHari()">
								</div>
								<div class="form-group">
									<label for="tgl_co">Checkout</label>
									<input type="date" id="TK" class="form-control txtDate" value="<?php echo $co ?>" onchange="hitungHari()">
								</div>
								<div class="form-group">
									<label for="jml_adlt">Dewasa</label>
									<select id="jml_adlt" name="org_dewasa" class="form-control">
										<option>Adult</option>
										<option <?php if ($adt == "1" ) echo 'selected' ; ?> value="1">1</option>
										<option <?php if ($adt == "2" ) echo 'selected' ; ?> value="2">2</option>
									</select>
								</div>
								<div class="form-group">
									<label for="jml_ank">Anak-anak</label>
									<select name="anak" id="jml_ank" class="form-control">
										<option value="0">Children</option>
										<option <?php if ($cld == 1 ) echo 'selected' ; ?> value="1">1</option>
										<option <?php if ($cld == 2 ) echo 'selected' ; ?> value="2">2</option>
									</select>
								</div>
								<div class="form-group">
									<label>Jumlah hari</label>
									<input type="text" id="jumlahHari" name="total_tanggal" value="<?php echo "$jml" ?>" class="form-control" readonly>
								</div>
								<div class="col text-center">
									<button type="submit" class="btn btn-primary shadow-sm" name="submit">Checkout</button>
									<a href="../index.php" class="btn btn-secondary">Cancel</a>
								</div>
							</form>
            </div>
          </div>
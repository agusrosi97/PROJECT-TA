					<div class="col-lg-4 ftco-animate">
					  <div id="contentTwo" class="card border p-4 mb-2 b-top-content shadow-sm" tabindex="-1">
					  	<h2 class="text-center border-bottom pb-4">Reservasi Anda</h2>

					    <form id="form_reservasi" action="" method="POST">

					    	<input type="hidden" name="nama_kamar" value="Tipe Dua">
					    	<input type="hidden" name="tipe_kamar" value="2">

								<div class="form-group">
									<label for="tgl_c1">Checkin</label>
									<input type="text" id="TM" class="form-control txtDate inputangka" value="<?php echo $tglCI ?>" onchange="hitung()" name="inpCekIn" readonly>
								</div>

								<div class="form-group">
									<label for="tgl_co">Checkout</label>
									<input type="text" id="TK" class="form-control txtDate inputangka" value="<?php echo $tglCO ?>" onchange="hitung();" name="inpCekOut" readonly>
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
									<label for="jmlKamar">Jumlah kamar</label>
									<input type="text" id="jmlKamar" class="form-control" name="jumlah_kamar" readonly value="0">
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
					          <input type="text" class="form-control" id="total_harga" readonly style="font-weight: bold; font-size: 20px" name="total_harga" value="0">
					        </div>
					      </div>

								<div class="col text-center px-0">
									<button id="btnPesan_reservasi" class="btn btn-primary rounded shadow-sm mt-2" type="submit" name="submitPesanan" style="width: 100%; font-size: 20px">Lanjut <i class="fas fa-shopping-cart" style="font-size: 13px"></i></button>
								</div>
							</form>
					  </div>
					</div>
<div class="modal fade" id="popupTambah_Reservasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Reservasi</h5>
        <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form method="POST" action="">
          <?php 
            $getNamaTamu = mysqli_query($conn, "SELECT * FROM tbl_tamu WHERE id_tamu = '$aa'");
            $datatamu = mysqli_fetch_assoc($getNamaTamu);
          ?>
          <input type="hidden" value="<?=$datatamu['id_tamu']; ?>" name="id_tamu">
          <input type="hidden" name="ketRes_Tamu" value="Offline">
          <div class="form-group row">
            <label for="nmtamu" class="col-lg-2 col-form-label">Nama Tamu :</label>
            <div class="col-lg-6">
              <input type="text" class="form-control pem border-top-0 border-left-0 border-right-0" id="nmtamu" value="<?=$datatamu['nama_tamu'] ?>" readonly>
            </div>
            <div class="col-lg-4 d-flex align-items-start">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-light">Rp</span>
                </div>
                <input type="text" class="form-control" id="total_harga" readonly style="font-weight: bold; font-size: 20px; position: -webkit-sticky;position: sticky !important; top: 4rem;" name="total_harga" value="0">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 right-border">
              <!-- <p><i>Keterangan</i></p> -->
              <div class="form-group">
                <label for="TM">Tanggal Checkin <sup class="harus-isi">*</sup></label>
                <input id="TM" class="form-control pem" type="text" name="inp_CekIn" onchange="hitung(); disableCheck();" readonly>
              </div>
              <div class="form-group">
                <label for="TK">Tanggal Checkout <sup class="harus-isi">*</sup></label>
                <input id="TK" class="form-control pem" type="text" name="inp_CekOut" onchange="hitung(); disableCheck()" readonly>
              </div>
              <div class="form-group">
                <label for="jmldwsa">Dewasa <sup class="harus-isi">*</sup></label>
                <select id="jmldwsa" name="inp_orgDewasa" class="form-control" required>
                  <option value="0">Adult</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="jmlanak">Anak-anak</label>
                <select id="jmlanak" class="form-control" name="inp_Anak">
                  <option value="0">Children</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="jumlahHari">Jumlah hari </label>
                <input type="text" id="jumlahHari" name="total_tanggal" class="form-control inputangka" readonly value="0">
              </div>
              <div class="form-group">
                <label for="jmlKamar">Jumlah kamar</label>
                <input type="text" id="jmlKamar" class="form-control" name="jumlah_kamar" readonly value="0">
              </div>
            </div>
            <div class="col-lg-7">
              <p><i>Pilih Kamar</i></p>
              <?php
                $i = 1;
                while ($rowTK = mysqli_fetch_array($queKamar)) : ?>
                  <div class="form-row border-bottom">
                    <div class="form-group col-lg-1 d-flex align-self-center mb-0 mr-2">
                      <div class="checkbox-custom" style="line-height: 1">
                        <label style="font-size: 1.5em;" class="d-flex justify-content-center align-items-center mb-0 forrup" onchange='hitung();'>
                          <input id="btnKamar_<?=$i;?>" type="checkbox" value="<?php echo $rowTK['id_tipe_kamar'] ?>" name="id_kamar[]">
                          <span class="cr" tabindex="-1"><i class="cr-icon fa fa-check"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group col-lg-5 mb-1">
                      <label for="btnKamar_<?=$i;?>" class="form-control border-0 pl-0" onchange='hitung();'><h4><?=$rowTK["nama_tipe_kamar"] ?></h4></label>
                      <label for="btnKamar_<?=$i;?>" onchange='hitung();'><p class="mb-0 pb-0">Rp.<?=number_format($rowTK["harga_kamar"],2,',','.')?>,-</p></label>
                      <input type="hidden" id="hargaPerKamar<?=$i?>" value="<?php if($rowTK['harga_kamar'] <= 0) : ?>0<?php else : ?><?= $rowTK['harga_kamar'] ?><?php endif; ?>">
                    </div>
                    <div class="form-group col-lg-5">
                      <label for="Kamar<?=$i?>">Jumlah kamar</label>
                      <select name="jumlahKamarPerPilihan[]" class="form-control" onchange='hitung();' id="Kamar<?=$i?>" disabled>
                        <?php
                          $j = 0;
                          for ($x = 0; $x <= $rowTK['jumlah_kamar']; $x++) {?>
                            <option value='<?php echo $x ?>'><?php echo $j; ?></option>
                            <?php
                            $j++;
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                <?php
                ++$i;
                endwhile;
              ?>
              <p class="text-center mt-2"><i>Tidak ada kamar untuk diampilkan lagi.</i></p>
            </div>
          </div>
        <!-- asasas -->
        <div class="modal-footer text-center justify-content-center mt-3">
          <button type="button" class="btn btn-secondary rounded btnClose" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary rounded" id="btnPesan_reservasi" name="submitTambahReservasi">Simpan</button>
        </div>
      </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="popupUbah_Reservasi_<?=$row['id_reservasi']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalScrollableTitle"><div class="smalest-screen d-flex"><span class="pr-2"><i class="fas fa-pen text-warning"></i></span> <span class="pr-3 mr-3 right-border2">Reservasi</span></div>
          <div class="d-flex harga-small">
            <div class="d-flex py-0 pl-sm-3 m-0">
              Rp.<input type="text" class="form-control pem border-0 p-0 m-0 col" id="total_harga_duplicate2_<?=$no;?>" readonly style="font-weight: bold; font-size: 20px; height: 100% !important; box-shadow: none; outline: none;" value="0">
            </div>
          </div>
        </h5>
        <button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <input type="hidden" name="id_reservasi" value="<?=$row['id_reservasi'] ?>">
          <div class="form-group row">
            <label for="nmtamu<?=$no;?>" class="col-lg-2 col-form-label">Nama Tamu :</label>
            <div class="col-lg-6">
              <input type="text" class="form-control pem border-top-0 border-left-0 border-right-0" id="nmtamu<?=$no;?>" value="<?=$row['nama_tamu'] ?>" readonly>
            </div>
            <div class="col-lg-4 d-flex align-items-start auto-Hide">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-light">Rp</span>
                </div>
                <!-- /////////////////////////////////////////////////////////////// -->
                <!--                           TOTAL HARGA                           -->
                <!-- /////////////////////////////////////////////////////////////// -->
                <input type="text" class="form-control" id="total_hargaa_<?=$no;?>" readonly style="font-weight: bold; font-size: 20px" name="total_hargaa" value="0">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 right-border">
              <div class="form-group">
                <label for="TMM_<?=$no;?>">Tanggal Checkin <sup class="harus-isi">*</sup></label>
                <input id="TMM_<?=$no;?>" class="form-control pem" type="text" name="inp_CekIn" onchange="hitung2(); disableCheck2();" readonly value="<?=$row['tgl_checkin'] ?>">
              </div>
              <div class="form-group">
                <label for="TKK_<?=$no;?>">Tanggal Checkout <sup class="harus-isi">*</sup></label>
                <input id="TKK_<?=$no;?>" class="form-control pem" type="text" name="inp_CekOut" onchange="hitung2(); disableCheck2()" readonly value="<?=$row['tgl_checkout'] ?>">
              </div>
              <div class="form-group">
                <label for="jmldwsa<?=$no;?>">Dewasa <sup class="harus-isi">*</sup></label>
                <select id="jmldwsa<?=$no;?>" name="inp_orgDewasa" class="form-control" required>
                  <option value="0">Adult</option>
                  <option <?php if ($row['jumlah_orang'] == "1" ) echo 'selected' ; ?> value="1">1</option>
                  <option <?php if ($row['jumlah_orang'] == "2" ) echo 'selected' ; ?> value="2">2</option>
                  <option <?php if ($row['jumlah_orang'] == "3" ) echo 'selected' ; ?> value="3">3</option>
                  <option <?php if ($row['jumlah_orang'] == "4" ) echo 'selected' ; ?> value="4">4</option>
                  <option <?php if ($row['jumlah_orang'] == "5" ) echo 'selected' ; ?> value="5">5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="jmlanak<?=$no;?>">Anak-anak</label>
                <select id="jmlanak<?=$no;?>" class="form-control" name="inp_Anak">
                  <option value="0">Children</option>
                  <option <?php if ($row['jumlah_anak'] == "1" ) echo 'selected' ; ?> value="1">1</option>
                  <option <?php if ($row['jumlah_anak'] == "2" ) echo 'selected' ; ?> value="2">2</option>
                  <option <?php if ($row['jumlah_anak'] == "3" ) echo 'selected' ; ?> value="3">3</option>
                  <option <?php if ($row['jumlah_anak'] == "4" ) echo 'selected' ; ?> value="4">4</option>
                  <option <?php if ($row['jumlah_anak'] == "5" ) echo 'selected' ; ?> value="5">5</option>
                </select>
              </div>
              <!-- /////////////////////////////////////////////////////////////// -->
              <!--                           JUMLAH HARI                           -->
              <!-- /////////////////////////////////////////////////////////////// -->
              <div class="form-group">
                <label for="jumlahHarii">Jumlah hari </label>
                <input type="text" id="jumlahHarii_<?=$no; ?>" name="total_tanggal" class="form-control inputangka" readonly value="<?=$row['jumlah_hari'] ?>">
              </div>
              <!-- /////////////////////////////////////////////////////////////// -->
              <!--                           JUMLAH KAMAR                          -->
              <!-- /////////////////////////////////////////////////////////////// -->
              <div class="form-group">
                <label for="jmlKamarr">Jumlah kamar</label>
                <input type="text" id="jmlKamarr_<?=$no;?>" class="form-control" name="jumlah_kamar" readonly value="0">
              </div>
            </div>
            <div class="col-lg-7">
              <?php $queryKamar = mysqli_query($conn, "SELECT * FROM tbl_tipe_kamar WHERE jumlah_kamar > 0"); ?>
              <p><i>Pilih Kamar</i></p>
              <?php
                $i = 1;
                foreach ($queryKamar as $rowTK) : ?>
                  <div class="form-row border-bottom">
                    <div class="form-group col-sm-1 d-flex align-self-center mb-0 mr-2">
                      <div class="checkbox-custom" data-toggle="tooltip" data-placement="top" title="klik untuk memilih" style="line-height: 1">
                        <label style="font-size: 1.5em;" class="d-flex justify-content-center align-items-center mb-0 forrup" onchange='hitung2();'>
                          <!-- /////////////////////////////////////////////////////////////// -->
                          <!--                        CHECKBOX KAMAR                           -->
                          <!-- /////////////////////////////////////////////////////////////// -->
                          <input id="btnKamarr_<?=$no;?><?=$i?>" type="checkbox" value="<?php echo $rowTK['id_tipe_kamar'] ?>" name="id_kamar[]">
                          <span class="cr" tabindex="-1"><i class="cr-icon fa fa-check"></i></span>
                        </label>
                      </div>
                    </div>
                    <div class="form-group col-5 mb-1">
                      <label for="btnKamarr_<?=$no;?><?=$i?>" class="form-control border-0 pl-0" onchange='hitung2();'><h4><?=$rowTK["nama_tipe_kamar"] ?></h4></label>
                      <label for="btnKamarr_<?=$no;?><?=$i?>" onchange='hitung2();'><p class="mb-0 pb-0">Rp.<?=number_format($rowTK["harga_kamar"],2,',','.')?>,-</p></label>
                      <!-- /////////////////////////////////////////////////////////////// -->
                      <!--                           HARGA PER KAMAR                       -->
                      <!-- /////////////////////////////////////////////////////////////// -->
                      <input type="hidden" id="hargaPerKamarr<?=$no;?><?=$i;?>" value="<?php if($rowTK['harga_kamar'] <= 0) : ?>0<?php else : ?><?= $rowTK['harga_kamar'] ?><?php endif; ?>">
                    </div>
                    <div class="form-group col">
                      <label for="Kamarr<?=$no;?><?=$i?>">Jumlah kamar</label>
                      <!-- /////////////////////////////////////////////////////////////// -->
                      <!--                    SELECT OPTION KAMAR                          -->
                      <!-- /////////////////////////////////////////////////////////////// -->
                      <select name="jumlahKamarPerPilihan[]" class="form-control" onchange='hitung2();' id="Kamarr<?=$no;?><?=$i?>" disabled>
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
                endforeach;
              ?>
              <p class="text-center mt-2"><i>Tidak ada kamar untuk diampilkan lagi.</i></p>
            </div>
          </div>
        <!-- /form -->
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded btnClose" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" id="btnPesan_reservasii_<?=$no;?>" name="submitEditReservasi_<?=$no; ?>">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
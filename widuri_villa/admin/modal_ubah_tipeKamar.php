<div class="modal fade" id="popup_Ubah_TipeKam_<?=$row["id_tipe_kamar"];?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header shadow-sm py-2">
        <h5 class="modal-title"><i class="fas fa-pen text-warning"></i> Tipe Kamar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" enctype="multipart/form-data">
          
          <input type="hidden" value="<?php echo $row["id_tipe_kamar"] ?>" name="id">
          <input type="hidden" value="<?php echo $row["foto_tipe_kamar"]; ?>" name="udt_fotoTipeKamar_Lama">

          <div class="col-md-12 d-flex justify-content-center align-items-center mb-3 px-0">
            <label for="img<?=$i;?>" class="custom-file-upload tipeKamar" title="Foto tipe kamar">
              <div class="wrapper-imgKamar shadow-sm img-thumbnail">
                <i class="fas fa-image"></i>
                <img id="preview-img<?="$i";?>" class="img-fluid" src="../assets/foto_tipe_kamar/<?php echo $row["foto_tipe_kamar"]; ?>" alt=""  />
                <span class="hover--img"></span>
              </div>
            </label>
            <input type="file" class="FotoUpload" id="img<?=$i;?>" name="udt_foto_tipeKamar" value="<?php echo $row["foto_tipe_kamar"]; ?>">
          </div>
          
          <div class="col px-0">
            <div class="form-group">
              <label for="NamaKamar<?= $i ?>">Nama Tipe Kamar</label>
              <input id="NamaKamar<?= $i ?>" class="form-control" type="text" name="udt_namaKamar" placeholder="Nama kamar" value="<?php echo $row["nama_tipe_kamar"] ?>">
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="JmlKam<?= $i ?>">Jumlah Kamar</label>
                <input id="JmlKam<?= $i ?>" class="form-control" type="number" name="udt_jumlahKamar" min="0" placeholder="Jumlah" value="<?php echo $row["jumlah_kamar"] ?>">
              </div>

              <div class="form-group col-md-8">
                <label for="harga<?= $i ?>">Harga Kamar</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input id="harga<?= $i ?>" class="form-control" type="number" name="udt_hargaKamar" min="1" placeholder="Rp" value="<?php echo $row["harga_kamar"] ?>">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              
              <label class="mb-2 col-3 pl-0 ">Fasilitas</label>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="wifi<?= $i ?>" name="udt_fasilitas[]" value="Wifi" <?php if(in_array('Wifi', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="wifi<?= $i ?>">Wifi</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="sarapan<?= $i ?>" name="udt_fasilitas[]" value="Sarapan pagi" <?php if(in_array('Sarapan pagi', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="sarapan<?= $i ?>">Sarapan pagi</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="servis<?= $i ?>" name="udt_fasilitas[]" value="Service kamar 24jam" <?php if(in_array('Service kamar 24jam', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="servis<?= $i ?>">Service kamar 24jam</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="kolam<?= $i ?>" name="udt_fasilitas[]" value="Kolam renang" <?php if(in_array('Kolam renang', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="kolam<?= $i ?>">Kolam renang</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="dapur<?= $i ?>" name="udt_fasilitas[]" value="Dapur" <?php if(in_array('Dapur', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="dapur<?= $i ?>">Dapur</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="gazebo<?= $i ?>" name="udt_fasilitas[]" value="Gazebo" <?php if(in_array('Gazebo', $centangArray)): echo 'checked="checked"'; endif; ?>>
                <label class="custom-control-label" for="gazebo<?= $i ?>">Gazebo</label>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center pb-1 mt-2 col-12">
            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary rounded" name="submit_ubahTPKamar">Simpan</button>
          </div>
      </div>
        </form>
    </div>
  </div>
</div>
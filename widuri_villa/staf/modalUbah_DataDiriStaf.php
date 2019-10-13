<div class="modal fade" id="popupUbahPengguna_<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg shadow" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" enctype="multipart/form-data">

          <div class="row">

            <div class="col-md-3">
              <div class="d-flex justify-content-center align-items-center">
                <label for="imgInp" class="custom-file-upload">
                  <div class="wrapper-avatar shadow">
                    <i class="fas fa-image"></i>
                    <img id="blah" src="../assets/foto_pengguna/<?php echo $fotonya ?>" alt="" />
                    <span class="hover--img"></span>
                  </div>
                </label>
                <input id="imgInp" type="file" name="inp_foto_pengguna" value="<?php echo $fotonya ?>">
              </div>
              <p class="text-center">Ukuran foto < 2Mb</p>

            </div>

            <div class="col-md-9">

              <input type="hidden" name="id" value="<?php echo $id ?>">

              <div class="form-row">

                <div class="form-group col-md-7">
                  <label for="nm-tamu">Nama Anda</label>
                  <input id="nm-tamu" class="form-control" type="text" name="inp_nama_pengguna" placeholder="Nama Anda" value="<?php echo $namanya ?>" required>
                </div>

                <div class="form-group col-md-5">
                  <label for="tgllhir">Tanggal lahir</label>
                  <input id="tgllhir" class="form-control" type="date" name="inp_tgllahir_pengguna" value="<?php echo $tglLahirnya ?>" required>
                </div>

                <div class="form-group col-md-7">
                  <label for="emil">Email</label>
                  <input id="emil" class="form-control" type="email" name="inp_email_pengguna" placeholder="Email Anda" value="<?php echo $emailnya ?>" disabled>
                </div>
                
                <div class="form-group col-md-5">
                  <label for="tlp">No Telp</label>
                  <input id="tlp" class="form-control" type="number" name="inp_tlp_pengguna" placeholder="Telepon Tamu" value="<?php echo $notelpnya ?>" required>
                </div>

                <div class="form-group col-md-6">
                  <label for="jkel">JKel</label>
                  <select id="jkel" class="form-control" name="inp_jk_pengguna">
                    <option value="L" <?php if($jk_pengguna == 'L') {echo "selected";} ?>>Laki - Laki</option>
                    <option value="P" <?php if($jk_pengguna == 'P') {echo "selected";} ?>>Perempuan</option>
                  </select>
                </div>

                <div class="form-group col-md-12">
                  <label for="almt">Alamat Tamu</label>
                  <textarea id="almt" class="form-control" placeholder="Alamat Tamu" name="inp_alamat_pengguna" required><?php echo $alamatnya ?></textarea>
                </div>

              </div>
            </div>
          </div>
          
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submitUbahDataDiri_Pengguna">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
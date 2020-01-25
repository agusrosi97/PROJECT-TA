<div class="modal fade" id="popupUbahPengguna_<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg shadow" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light shadow-sm py-2">
        <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="fas fa-pen text-warning"></i> Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" enctype="multipart/form-data">
          
          <input type="hidden" name="id" value="<?php echo $id ?>">
          <input id="fotoLamanya" type="hidden" name="fotoLamanya" value="<?php echo $fotonya ?>">

          <div class="row">

            <div class="col-md-3">
              <div class="col-md-12 d-flex justify-content-center align-items-center">
                <label for="img1" class="custom-file-upload">
                  <div class="wrapper-avatar shadow">
                    <i class="fas fa-user-plus"></i>
                    <img id="preview-img1" src="../assets/foto_pengguna/<?php echo $fotonya ?>" alt="" />
                    <span class="hover--img"></span>
                  </div>
                </label>
                <input type="file" class="FotoUpload" id="img1" name="inp_foto_pengguna">
              </div>

              <p class="text-center">Ukuran foto < 2Mb</p>
              <?php if($fotonya ===""):?>
              <?php else: ?>
                <div class="text-center">
                  <button type="button" class="btn btn-outline-danger rounded shadow-sm py-0" onclick="removeImage();"><i class="fas fa-trash"></i> Hapus foto</button>
                </div>
              <?php endif; ?>
              <script type="text/javascript">
                function removeImage() {
                  document.getElementById('preview-img1').src="";
                  document.getElementById('fotoLamanya').value ="";
                }
              </script>

            </div>

            <div class="col-md-9">

              <div class="form-row">

                <div class="form-group col-md-7">
                  <label for="nm-pengguna">Nama Anda</label>
                  <input id="nm-pengguna" class="form-control" type="text" name="inp_nama_pengguna" placeholder="Nama Anda" value="<?php echo $namanya ?>" required>
                </div>

                <div class="form-group col-md-5">
                  <label for="tgllhir-pengguna">Tanggal lahir</label>
                  <input id="tgllhir-pengguna" class="form-control" type="date" name="inp_tgllahir_pengguna" value="<?php echo $tglLahirnya ?>" required>
                </div>

                <div class="form-group col-md-7">
                  <label for="emil-pengguna">Email</label>
                  <input id="emil-pengguna" class="form-control" type="email" name="inp_email_pengguna" placeholder="Email Anda" value="<?php echo $emailnya ?>" disabled>
                </div>
                
                <div class="form-group col-md-5">
                  <label for="tlp-pengguna">No Telp</label>
                  <input id="tlp-pengguna" class="form-control" type="number" name="inp_tlp_pengguna" placeholder="Telepon Tamu" value="<?php echo $notelpnya ?>" required>
                </div>

                <div class="form-group col-md-6">
                  <label for="jkel-pengguna">JKel</label>
                  <select id="jkel-pengguna" class="form-control" name="inp_jk_pengguna">
                    <option value="L" <?php if($jk_pengguna == 'L') {echo "selected";} ?>>Laki - Laki</option>
                    <option value="P" <?php if($jk_pengguna == 'P') {echo "selected";} ?>>Perempuan</option>
                  </select>
                </div>

                <div class="form-group col-md-12">
                  <label for="almt-pengguna">Alamat Tamu</label>
                  <textarea id="almt-pengguna" class="form-control" placeholder="Alamat Tamu" name="inp_alamat_pengguna" required><?php echo $alamatnya ?></textarea>
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
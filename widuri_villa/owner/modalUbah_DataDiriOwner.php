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

          <input type="hidden" name="id" value="<?php echo $id ?>">

          <div class="row">
            <div class="col-md-3">
              
              <div class="d-flex justify-content-center align-items-center">
                <label for="imgInp" class="custom-file-upload">
                  <div class="wrapper-avatar shadow">
                    <i class="fas fa-user-plus"></i>
                    <img id="blah" src="../assets/foto_pengguna/<?php echo $fotonya ?>" alt="" />
                    <span class="hover--img"></span>
                  </div>
                </label>
                <input id="imgInp" type="file" name="inp_foto_pengguna" value="<?php echo $fotonya ?>">
              </div>
              <p class="text-center">Ukuran foto < 2Mb</p>

            </div>

            <div class="col-md-9">

              <div class="form-row">

                <div class="form-group col-md-7">
                  <label for="udtNama_owner">Nama Anda</label>
                  <input id="udtNama_owner" class="form-control" type="text" name="inp_nama_pengguna" placeholder="Nama Anda" value="<?php echo $namanya ?>" required>
                </div>

                <div class="form-group col-md-5">
                  <label for="udtTgl_owner">Tanggal lahir</label>
                  <input id="udtTgl_owner" class="form-control" type="date" name="inp_tgllahir_pengguna" value="<?php echo $tglLahirnya ?>" required>
                </div>

                <div class="form-group col-md-7">
                  <label>Email</label>
                  <input class="form-control" type="email" name="inp_email_pengguna" placeholder="Email Anda" value="<?php echo $emailnya ?>" disabled>
                </div>
                
                <div class="form-group col-md-5">
                  <label for="udtTlp_owner">No Telp</label>
                  <input id="udtTlp_owner" class="form-control" type="number" name="inp_tlp_pengguna" placeholder="Telepon Tamu" value="<?php echo $notelpnya ?>" required>
                </div>

                <div class="form-group col-md-6">
                  <label for="udtJkel_owner">JKel</label>
                  <select id="udtJkel_owner" class="form-control" name="inp_jk_pengguna">
                    <option value="L" <?php if($jk_pengguna == 'L') {echo "selected";} ?>>Laki - Laki</option>
                    <option value="P" <?php if($jk_pengguna == 'P') {echo "selected";} ?>>Perempuan</option>
                  </select>
                </div>

                <div class="form-group col-md-12">
                  <label for="udtAlmt_owner">Alamat Tamu</label>
                  <textarea id="udtAlmt_owner" class="form-control" placeholder="Alamat Tamu" name="inp_alamat_pengguna" required><?php echo $alamatnya ?></textarea>
                </div>

              </div>
            </div>
          </div>
          
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal"><i class="fas fa-times"></i>&nbsp;Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submitUbahDataDiri_Pengguna"><i class="fas fa-check"></i>&nbsp;Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
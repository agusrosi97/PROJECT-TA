<div class="modal fade" id="popup_ubah_pengguna_<?php echo $row["id_pengguna"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form method="POST" action="" enctype="multipart/form-data">

          <input type="hidden" name="id" value="<?php echo $row["id_pengguna"] ?>">
          <input type="hidden" name="inp_foto_pengguna" value="<?php echo $row["foto_pengguna"] ?>">

          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="uptNama_OwnerPeng">Nama Pengguna <sup class="harus-isi">*</sup></label>
              <input id="uptNama_OwnerPeng" class="form-control" type="text" name="inp_nama_pengguna" placeholder="Nama Pengguna" value="<?php echo $row["username_pengguna"] ?>" required>
            </div>

            <div class="form-group col-md-5">
              <label for="uptTglLahir_OwnerPeng">Tanggal lahir <sup class="harus-isi">*</sup></label>
              <input id="uptTglLahir_OwnerPeng" class="form-control" type="date" name="inp_tgllahir_pengguna" value="<?php echo $row["tgl_lahir_pengguna"] ?>" required>
            </div>

            <div class="form-group col-md-7">
              <label for="uptEmail_OwnerPeng">Email</label>
              <input id="uptEmail_OwnerPeng" class="form-control" type="email" name="inp_email_pengguna" placeholder="Email Tamu" value="<?php echo $row["email_pengguna"] ?>" disabled>
            </div>
            
            <div class="form-group col-md-5">
              <label for="uptTlp_OwnerPeng">No Telp <sup class="harus-isi">*</sup></label>
              <input id="uptTlp_OwnerPeng" class="form-control" type="number" name="inp_tlp_pengguna" placeholder="Telepon Tamu" value="<?php echo $row["no_telp_pengguna"] ?>" required>
            </div>

            <div class="form-group col-md-6">
              <label for="uptAkses_OwnerPeng">Hak Akses <sup class="harus-isi">*</sup></label>
              <select id="uptAkses_OwnerPeng" class="form-control" name="inp_akses_pengguna">
                <!-- <option value="owner" <?php if($row["hak_akses_pengguna"] == 'owner') {echo "selected";} ?>>Owner</option> -->
                <option value="admin" <?php if($row["hak_akses_pengguna"] == 'admin') {echo "selected";} ?>>Admin</option>
                <option value="staf" <?php if($row["hak_akses_pengguna"] == 'staf') {echo "selected";} ?>>Staf Reservasi</option>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="uptJK_OwnerPeng">JKel <sup class="harus-isi">*</sup></label>
              <select id="uptJK_OwnerPeng" class="form-control" name="inp_jk_pengguna">
                <option value="L" <?php if($row["jk_pengguna"] == 'L') {echo "selected";} ?>>Laki - Laki</option>
                <option value="P" <?php if($row["jk_pengguna"] == 'P') {echo "selected";} ?>>Perempuan</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="uptAlamat_OwnerPeng">Alamat Tamu <sup class="harus-isi">*</sup></label>
              <textarea id="uptAlamat_OwnerPeng" class="form-control" placeholder="Alamat Pengguna" name="inp_alamat_pengguna" required><?php echo $row["alamat_pengguna"]; ?></textarea>
            </div>

          </div>
        <!-- asasas -->
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submit_ubah">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
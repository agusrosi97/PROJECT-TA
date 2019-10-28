<div class="modal fade" id="popup_ubah_tamu_<?php echo $row["id_tamu"] ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Data Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form method="POST" action="" enctype="multipart/form-data">

          <input type="hidden" name="id" value="<?php echo $row["id_tamu"] ?>">
          <input type="hidden" name="inp_foto_tamu" value="<?php echo $row["foto_tamu"] ?>">

          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="nm-tamu-<?php echo $i; ?>">Nama Tamu <sup class="harus-isi">*</sup></label>
              <input id="nm-tamu-<?php echo $i; ?>" class="form-control" type="text" name="inp_nama_tamu" placeholder="Nama Tamu" value="<?php echo $row["nama_tamu"] ?>" required>
            </div>

            <div class="form-group col-md-5">
              <label for="tgllhir-<?php echo $i; ?>">Tanggal lahir <sup class="harus-isi">*</sup></label>
              <input id="tgllhir-<?php echo $i; ?>" class="form-control" type="date" name="inp_tgllahir_tamu" value="<?php echo $row["tgl_lahir_tamu"] ?>" required>
            </div>

            <div class="form-group col-md-7">
              <label for="emil-<?php echo $i ?>">Email <sup class="harus-isi">*</sup></label>
              <input id="emil-<?php echo $i ?>" class="form-control" type="email" name="inp_email_tamu" placeholder="Email Tamu" value="<?php echo $row["email_tamu"] ?>" disabled>
            </div>
            
            <div class="form-group col-md-5">
              <label for="tlp-<?php echo $i ?>">No Telp <sup class="harus-isi">*</sup></label>
              <input id="tlp-<?php echo $i ?>" class="form-control" type="number" name="inp_tlp_tamu" placeholder="Telepon Tamu" value="<?php echo $row["no_telp_tamu"] ?>" required>
            </div>

            <div class="form-group col-md-6">
              <label for="jkel-<?php echo $i ?>">JKel <sup class="harus-isi">*</sup></label>
              <select id="jkel-<?php echo $i ?>" class="form-control" name="inp_jk_tamu">
                <option value="L" <?php if($row["jk_tamu"] == 'L') {echo "selected";} ?>>Laki - Laki</option>
                <option value="P" <?php if($row["jk_tamu"] == 'P') {echo "selected";} ?>>Perempuan</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="almt-<?php echo $i ?>">Alamat Tamu <sup class="harus-isi">*</sup></label>
              <textarea id="almt-<?php echo $i ?>" class="form-control" placeholder="Alamat Tamu" name="inp_alamat_tamu" required><?php echo $row["alamat_tamu"]; ?></textarea>
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
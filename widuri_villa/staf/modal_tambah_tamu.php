<div class="modal fade" id="popup_tambah_tamu" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Data Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="nm-tamu">Nama Tamu <sup class="harus-isi">*</sup></label>
              <input id="nm-tamu" class="form-control" type="text" name="inp_nama_tamu" placeholder="Nama Tamu" required>
            </div>

            <div class="form-group col-md-5">
              <label for="tgllahir">Tanggal lahir <sup class="harus-isi">*</sup></label>
              <input id="tgllahir" class="form-control pem" type="text" name="inp_tgllahir_tamu" placeholder="Tanggal lahir" readonly required>
            </div>

            <div class="form-group col-md-7">
              <label for="emil">Email <sup class="harus-isi">*</sup></label>
              <input id="emil" class="form-control" type="email" name="inp_email_tamu" placeholder="Email Tamu" required>
            </div>
            
            <div class="form-group col-md-5">
              <label for="tlp">No Telp <sup class="harus-isi">*</sup></label>
              <input id="tlp" class="form-control" type="number" name="inp_tlp_tamu" placeholder="Telepon Tamu" required>
            </div>

            <div class="form-group col-md-6">
              <label for="jkel">JKel <sup class="harus-isi">*</sup></label>
              <select id="jkel" class="form-control" name="inp_jk_tamu">
                <option value="L">Laki - Laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="almt">Alamat Tamu <sup class="harus-isi">*</sup></label>
              <textarea id="almt" class="form-control" placeholder="Alamat Tamu" name="inp_alamat_tamu" required></textarea>
            </div>

          </div>
        <!-- asasas -->
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submit" id="TambahTamu">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
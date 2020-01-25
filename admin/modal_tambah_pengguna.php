<div class="modal fade" id="popup_tambah_pengguna" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header shadow-sm py-2">
        <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="fas fa-plus text-success"></i> Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form method="POST" action="" enctype="multipart/form-data">

          <input type="hidden" value="Aktif" name="inp_statusPengguna">

          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="insNama_Owner">Nama Pengguna <sup class="harus-isi">*</sup></label>
              <input id="insNama_Owner" class="form-control border-top-0 border-left-0 border-right-0" type="text" name="inp_nama_pengguna" placeholder="Nama Pengguna" required>
            </div>

            <div class="form-group col-md-5">
              <label for="insTglLahir_Owner">Tanggal lahir <sup class="harus-isi">*</sup></label>
              <input id="insTglLahir_Owner" class="form-control border-top-0 border-left-0 border-right-0" type="date" name="inp_tgllahir_pengguna" required>
            </div>

            <div class="form-group col-md-7">
              <label for="insEmail_Owner">Email <sup class="harus-isi">*</sup></label>
              <input id="insEmail_Owner" class="form-control border-top-0 border-left-0 border-right-0" type="email" name="inp_email_pengguna" placeholder="Email Pengguna" required>
            </div>
            
            <div class="form-group col-md-5">
              <label for="insTlp_Owner">No Telp <sup class="harus-isi">*</sup></label>
              <input id="insTlp_Owner" class="form-control border-top-0 border-left-0 border-right-0" type="number" name="inp_tlp_pengguna" placeholder="Telepon Pengguna" required>
            </div>

            <div class="form-group col-md-6">
              <label for="insLEvel_Owner">Hak Akses</label>
              <select name="inp_akses_pengguna" id="insLEvel_Owner" class="form-control border-top-0 border-left-0 border-right-0">
                <?php if($AdaOwner == null) : ?><option value="owner">Owner</option><?php else : ?><?php endif ?>
                <option value="admin">Admin</option>
                <option value="staf">Staf Reservasi</option>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="insJK_Owner">JKel <sup class="harus-isi">*</sup></label>
              <select id="insJK_Owner" class="form-control border-top-0 border-left-0 border-right-0" name="inp_jk_pengguna">
                <option value="L">Laki - Laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="insAlamat_Owner">Alamat Tamu <sup class="harus-isi">*</sup></label>
              <textarea id="insAlamat_Owner" class="form-control border-top-0 border-left-0 border-right-0" placeholder="Alamat Tamu" name="inp_alamat_pengguna" required></textarea>
            </div>

          </div>
        <!-- asasas -->
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submit">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
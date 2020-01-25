<div class="modal fade" id="popup_tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Data Reservasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
          <div class="container-contact100">
          <div class="wrap-contact100">
            <form class="contact100-form validate-form" method="POST" action="">
              <label class="label-input100" for="name">Nama Tamu</label>
              <a href=""></a>
              <div class="wrap-input100 validate-input">
                <input id="nm-tamu" class="input100" type="text" name="nama_tamu" placeholder="Nama Tamu" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="ci">Checkin</label>
              <div class="wrap-input100 validate-input">
                <input id="ci" class="input100" type="date" name="checkin_tamu" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="co">Checkout</label>
              <div class="wrap-input100 validate-input">
                <input id="co" class="input100" type="date" name="checkout_tamu" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="d">Jumlah Hari</label>
              <div class="wrap-input100 validate-input">
                <input id="d" class="input100" type="number" name="jumlah_hari" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="jd">J. Orang Dewasa</label>
              <div class="wrap-input100 validate-input">
                <input id="jd" class="input100" type="number" name="jumlah_dewasa" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="ja">J. Anak</label>
              <div class="wrap-input100 validate-input">
                <input id="ja" class="input100" type="number" name="jumlah_anak" required>
                <span class="focus-input100"></span>
              </div>

              <label class="label-input100" for="kt">Keterangan</label>
              <div class="wrap-input100 validate-input">
                <select id="kt" class="input100 custom-select1" name="jenis" required style="height: 40px">
                  <option class="custom-select1">-ket-</option>
                  <option value="Offline">Offline</option>
                  <option value="Online">Online</option>
                </select>
                <span class="focus-input100"></span>
              </div>
          </div>
        </div>
        <!-- asasas -->
      </div>
      <div class="modal-footer">
        <button type="button" style="border-radius: 2px;" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" style="border-radius: 2px;" class="btn btn-primary" name="simpan_reservasi">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
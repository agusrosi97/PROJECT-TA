<div class="modal fade" id="popup_ubah_TipeKam_<?php echo $row["id_tipe_kamar"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-sm shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">

          <input type="hidden" name="id" value="<?php echo $row["id_tipe_kamar"] ?>">

          <div class="form-group">
            <label for="uptJmlKamar">Jumlah Kamar</label>
            <input id="JmlKam" class="form-control" type="number" name="udt_jumlahKamar" value="<?php echo $row["jumlah_kamar"] ?>" required>
          </div>

          <div class="form-group">
            <label for="uptHargaKamar">Harga /Hari/Kamar</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
              </div>
              <input class="form-control" type="number" name="udt_hargaKamar" value="<?php echo $row["harga_kamar"] ?>" required>
            </div>
          </div>
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary rounded" name="submit_ubahTPKamar">Simpan</button>
      </div>
        </form>
    </div>
  </div>
</div>
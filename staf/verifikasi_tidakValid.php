<div class="modal fade" id="popUpReservasiGakvalid_<?php echo $row["id_transaksi"] ?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title">Verifikasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mh-100">
          <h3 class="text-center">Apakah foto yang diupload tidak sesuai?</h3>
        </div>
        <form method="POST" action="">
          <input type="hidden" name="id_transaksi" value="<?php echo $row["id_transaksi"] ?>">
          <input type="hidden" name="id_reservasi" value="<?php echo $row["id_reservasi"]; ?>">
          <input type="hidden" name="id_staf" value="<?php echo $id ?>">
          <input type="hidden" name="get_EmailTamu" value="<?=$row['email_tamu'] ?>">
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">BATAL</button>
        <input type="submit" class="btn btn-danger rounded" name="transaksiGakValid_<?=$i?>" value="TIDAK SESUAI">
      </div>
        </form>
    </div>
  </div>
</div>
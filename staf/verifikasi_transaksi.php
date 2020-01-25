<div class="modal fade" id="popUpReservasi_<?=$row["id_transaksi"] ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
          <h3 class="text-center">Anda sudah menerima pembayaran masuk dari Tamu yang bersangkutan?</h3>
        </div>
        <form method="POST" action="">
          <input type="hidden" name="id_transaksi" value="<?=$row["id_transaksi"] ?>">
          <input type="hidden" name="id_reservasi" value="<?=$row["id_reservasi"]; ?>">
          <input type="hidden" name="id_staf" value="<?=$id ?>">
      </div>
      <div class="modal-footer text-center justify-content-center">
        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">BELUM</button>
        <button type="submit" class="btn btn-primary rounded" name="transaksiValid_<?=$i?>">SUDAH</button>
      </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="popup_tambahReservasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Data Reservasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <div class="form-group">
            <label><h5 class="text-center">Cari Nama Tamu</h5></label>
            <select class="selectpicker mt-2 form-control rounded" data-live-search="true" title="Cari tamu" data-size="5" name="nama_tamu" id="selectIDtamu" onchange="makeSession();">
              <?php 
                while ($baris = mysqli_fetch_array($hasil)) : ?>
                  <option value="<?=$baris['id_tamu'] ?>" data-subtext="<?=$baris["email_tamu"] ?>"><?=$baris['nama_tamu']; ?></option>
                  <?php
                endwhile;
              ?>
            </select>
          </div>
          <div class="col text-center">
            <button id="submitCreateSessionTamu" type="submit" name="submitCreateSessionTamu" class="btn btn-primary rounded shadow-sm mb-3 px-5 py-2 d-none">SUBMIT</button>
          </div>
        </form>
        <div class="col text-center">
          <h3>Atau</h3>
        </div>
        <div class="col text-center mt-2">
          <button class="btn btn-primary font-weight-bold rounded shadow-sm text-uppercase">Input identitas Tamu</button>
        </div>
      </div>
    </div>
  </div>
</div>
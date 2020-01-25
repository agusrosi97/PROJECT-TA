<div class="modal fade" id="form-ca" tabindex="-1" role="dialog" aria-labelledby="modalcheckin" aria-hidden="true">
  <div class="modal-dialog shadow" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <form action="" method="POST">
          <!-- nampung hari -->
          <input type="text" class="d-none" id="jumlahHari" name="jml_hari">
          <!-- /nampung hari -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="TM">Check In</label>
              <input class="form-control txtDate" id="TM" placeholder="Tanggal checkin" name="ci" required autocomplete="off" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="TK">Check Out</label>
              <input class="form-control txtDate" id="TK" placeholder="Tanggal checkout" name="co"  required autocomplete="off" readonly>
            </div>
          </div>
          <div class="form-row">
            <div class="label-form-ck col">
              <div class="form-group">
                <label for="adlt">Adult</label>
                <div class="row">
                  <div class="form-tamu-inpt col-md-8 pr-0">
                    <select id="adlt" class="selectpicker form-control" name="adlt" title="Adult" required>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                  <div class="col-md-3 d-flex align-items-center">
                    <small class="text-muted">
                      Orang
                    </small>
                  </div>
                </div>
              </div>
            </div>
            <div class="label-form-ck col">
              <div class="form-group">
                <label for="child">Anak</label>
                <div class="row">
                  <div class="form-tamu-inpt col-md-8 pr-0">
                    <select id="child" class="selectpicker form-control" name="child" title="Children">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                  <div class="col-md-3 d-flex align-items-center">
                    <small class="text-muted">
                      Anak
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary col-md-12" name="inputReservasi">CHECK AVAILABILITY</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="popup_tambah_TipeKam" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header shadow-sm py-2">
        <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="fas fa-plus text-success"></i> Tipe Kamar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="col-md-12 d-flex justify-content-center align-items-center mb-3 px-0">
            <label for="img2" class="custom-file-upload tipeKamar" title="Foto tipe kamar">
              <div class="wrapper-imgKamar shadow-sm img-thumbnail">
                <i class="fas fa-image"></i>
                <img id="preview-img2" class="img-fluid" />
                <span class="hover--img"></span>
              </div>
            </label>
            <input type="file" class="FotoUpload" id="img2" name="inp_foto_tipeKamar" required>
          </div>

          <div class="col px-0">
            <div class="form-group">
              <label for="NamaKamar">Nama Tipe Kamar <sup class="harus-isi">*</sup></label>
              <input id="NamaKamar" class="form-control" type="text" name="inp_namaKamar" placeholder="Nama kamar">
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="JmlKam">Jumlah Kamar <sup class="harus-isi">*</sup></label>
                <input id="JmlKam" class="form-control" type="number" min="1" name="inp_jumlahKamar" placeholder="Jumlah">
              </div>

              <div class="form-group col-md-8">
                <label for="rp">Harga Kamar <sup class="harus-isi">*</sup></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                  </div>
                  <input id="rp" class="form-control" type="number" min="1" name="inp_hargaKamar" placeholder="Rp">
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label class="mb-2 col-3 pl-0 ">Fasilitas <sup class="harus-isi">*</sup></label>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="wifi" name="inp_fasilitas[]" value="Wifi">
                <label class="custom-control-label" for="wifi">Wifi</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="sarapan" name="inp_fasilitas[]" value="Sarapan pagi">
                <label class="custom-control-label" for="sarapan">Sarapan pagi</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="servis" name="inp_fasilitas[]" value="Service kamar 24jam">
                <label class="custom-control-label" for="servis">Service kamar 24jam</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="kolam" name="inp_fasilitas[]" value="Kolam renang">
                <label class="custom-control-label" for="kolam">Kolam renang</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="dapur" name="inp_fasilitas[]" value="Dapur">
                <label class="custom-control-label" for="dapur">Dapur</label>
              </div>
              <div class="custom-control custom-checkbox col-5 m-2">
                <input type="checkbox" class="custom-control-input" id="gazebo" name="inp_fasilitas[]" value="Gazebo">
                <label class="custom-control-label" for="gazebo">Gazebo</label>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center pb-1 mt-2 col-12">
            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary rounded" name="submit_tambahTPKamar">Simpan</button>
          </div>
      </div>
        </form>
    </div>
  </div>
</div>
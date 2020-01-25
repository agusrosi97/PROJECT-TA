<div class="modal fade" id="popup_ubah_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable shadow" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- asdasd -->
        <form action="" method="post">

          <input type="hidden" name="inp_id_pengguna" value="<?php echo $id ?>">

          <div class="form-group position-relative wrapper-inp-login">
            <label>Password Saat ini</label>
            <!-- input -->
            <input type="password" name="inp_pass_lama_pengguna" class="form-control login-inp" placeholder="Password saat ini." id="inp-pass-lama" autocomplete>
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass-lama">
              <i class="fas fa-eye"></i>
            </div>
          </div>

          <div class="form-group position-relative wrapper-inp-login">
            <label>Password Baru</label>
            <!-- input -->
            <input type="password" name="inp_pass_baru_pengguna" class="form-control login-inp" placeholder="Password baru" id="inp-pass-baru" autocomplete>
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-pass-baru">
              <i class="fas fa-eye"></i>
            </div>
          </div>

          <div class="form-group position-relative wrapper-inp-register">
            <label>Confirm Password</label>
            <!-- input -->
            <input type="password" class="form-control register-inp" placeholder="Confirm Password" id="inp-pass-confirm" name="inp_pass_ubah_pengguna" required autocomplete>
            <span class="inp-focus"></span>
            <div class="btn-show-password" title="Show password" id="btn-toggle-ubah-pass">
              <i class="fas fa-eye"></i>
            </div>
            <span id="pesan" class="pesan_check"><i class="fas fa-check"></i></span>
          </div>
        </div>
        <!-- asasas -->
      <div class="modal-footer text-center justify-content-center border-top-0">
        <div class="text-center">
          <button type="submit" name="submit_ubah_password" class="btn btn-darkblue btn-flat mb-2 m-t-30" id="btn-register">UBAH PASSWORD</button>
        </div>
      </div>
        </form>
    </div>
  </div>
</div>
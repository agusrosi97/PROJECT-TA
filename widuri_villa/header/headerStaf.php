      <!-- Header -->
      <header id="header" class="header">
        <div class="row">
          <div class="header-menu">
            <div class="col-sm-7 pl-3" >
              <div class="col-sm-1 pl-0 ml-0">
                <div id="menuToggle" class="tombol">
                  <i  class="fa fa-bars "></i>
                </div>
                <div id="menuToggle2" class="tombol2">
                  <i  class="fa fa-bars "></i>
                </div>
              </div>
            </div>
            <div class="col-sm-5 kecil">
              <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-sliders-h mt-1"></i>
                </a>
                <div class="user-menu dropdown-menu p-2">
                  <!-- card -->
                  <div class="card border-0 mb-0 position-relative" style="width: 16.2rem; min-height: 10rem">
                    <div class="card-body p-0 pt-2 card-account">
                      <button  type="button" class="btn btn-danger py-0 px-1 rounded" onclick="LogoutOnClick()" style="z-index: 1"><i class="fas fa-power-off"></i></button>
                      <div class="d-flex justify-content-center flex-column position-relative">
                        <div class="d-flex justify-content-center mb-2">
                          <div class="wrapper-avatar-pengguna shadow">
                            <?php if ($fotonya == '') : ?><img src="../assets/images/add-icon.png" alt=""><?php else : ?><img src="../assets/foto_pengguna/<?php echo $fotonya ?>" alt=""><?php endif ?>
                          </div>
                        </div>
                        <p class="card-text text-center word-wrap mb-4"><?php if ($namanya == true) { echo $namanya; } else {echo "Login dulu lah!";} ?></p>
                      </div>
                      <div class="d-flex justify-content-between wrapper-avatar-pengguna-footer flex-wrap">
                        <button class="btn btn-primary rounded" data-toggle="modal" data-target="#popupUbahPengguna_<?=$id?>">Ubah Profile</button>
                        <button type="button" class="btn btn-primary rounded" data-toggle="modal" data-target="#popup_ubah_password">Ubah Password</button>
                      </div>
                    </div>
                  </div>
                  <!-- /card -->
                </div>
              </div>
              <a class="float-right test" >Staf</a>
            </div>
          </div>
        </div>
      </header>
      <!-- /header -->
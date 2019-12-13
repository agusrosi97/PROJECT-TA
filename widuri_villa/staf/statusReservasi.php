                      <?php
                        $cekstatus = mysqli_query($conn, "SELECT * FROM tbl_transaksi_pembayaran WHERE id_transaksi = $row[id_reservasi]");
                        $baris = mysqli_fetch_assoc($cekstatus);
                        $statusRes = $baris["status"];
                        $fotoRes = $baris["foto_bukti_transaksi"];
                        // MENUNGGU
                        if ($statusRes === NULL && $fotoRes === NULL) : ?>
                          <div class="btn btn-success py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="Tamu baru saja melakukan pesanan." tabindex="0" style="cursor: help;">
                            <i class="fas fa-shopping-cart"></i> Booking
                          </div>
                        <?php elseif ($statusRes === NULL && $fotoRes !== NULL) : ?>
                          <div class="btn btn-danger2 py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="Menunggu konfirmasi." tabindex="0" style="cursor: help;">
                            <i class="fas fa-exclamation-triangle"></i> Menunggu
                          </div>
                        <?php elseif ($statusRes === 'GAK VALID') : ?>
                          <div class="btn btn-danger py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="<?php if($row['id_pengguna'] === NULL) :?>Transaski tidak valid dan ditolak oleh sistem. <?php elseif($row['id_pengguna'] === $id && $levelnya === 'staf') : ?>Anda telah menolak pesanan ini. <?php else : ?>Transaksi dengan ID TRN-0<?=$baris['id_transaksi'] ?> ditolah oleh <b><?=$row['username_pengguna'] ?></b>.<?php endif; ?>" tabindex="0" style="cursor: help;">
                            <i class="fas fa-times"></i> Ditolak
                          </div>
                        <?php elseif ($statusRes === 'VALID' && $fotoRes !== NULL && date("Y-m-d") >= $jam_reservasi && date("Y-m-d") < $row["tgl_checkin"])  : ?>
                          <div class="btn btn-success py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="<?php if($row["id_pengguna"] === $id && $levelnya === 'staf') : ?><b>Anda</b> telah mengkonfirmasi pesanan ini.<?php else : ?><b><?= $row["username_pengguna"]; ?></b> Telah mengkonfirmasi pesanan ini.<?php endif; ?>" tabindex="0" style="cursor: help;">
                            <i class="fas fa-check"></i> Diterima
                          </div>
                        <!-- CHECKIN -->
                        <?php elseif ($statusRes === 'VALID' && $fotoRes !== NULL && $row['tgl_checkin'] <= date('Y-m-d') && $row['tgl_checkout'] >= date('Y-m-d')) : ?>
                          <div class="btn btn-primary py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="<?php if($row['id_pengguna'] === $id && $levelnya === 'staf') : ?>Anda telah mengkonfirmasi pesanan ini. <?php else : ?>Transaksi dengan ID TRN-0<?=$baris['id_transaksi'] ?> dikonfirmasi oleh <b><?=$row['username_pengguna'] ?></b>.<?php endif; ?>" tabindex="0" style="cursor: help;">
                            <i class="fas fa-plane-arrival"></i> Checkin
                          </div>
                        <!-- Checkout -->
                        <?php elseif ($statusRes === 'VALID' && $fotoRes !== NULL && $row['tgl_checkout'] <= date("Y-m-d")) : ?>
                          <div class="btn btn-secondary py-0 px-1 rounded" title="Keterangan" data-toggle="popover" data-content="Tamu sudah checkout." tabindex="0" style="cursor: help;">
                            <i class="fas fa-plane-departure"></i> Checkout
                          </div>
                        <?php endif;
                      ?>
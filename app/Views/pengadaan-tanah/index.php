<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<?php if (user()->username == 'admin') : ?>
    <button class="btn btn-outline-success" data-toggle="modal" data-target="#tambahPengadaanTanah">
        Tambah Resume Pengadaan Tanah <i class="fa fa-plus"></i>
    </button>
<?php endif; ?>
<?php foreach ($jenis_pengadaan as $jpn): ?>
    <!-- Content Row -->
    <?php foreach ($last_upd_data as $tgl_upd): ?>
        <p>Data Upd : <?= date('F', strtotime($tgl_upd->tgl_upd)); // Convert to month name 
                            ?> <?= date('d, Y', strtotime($tgl_upd->tgl_upd)); // Display day and year 
                                ?></p>
    <?php endforeach; ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h6 class="h6 font-semibold mb-0 text-dark"><?= $jpn->nama_jenis ?></h6>
        </div>
        <div class="d-flex align-items-center">
            <form method="get" action="<?= base_url('resume/pengadaan-tanah/' . $slug); ?>" class="d-flex justify-content-end">
                <select name="tgl_upd" id="tgl_upd" class="form-control me-2">
                    <option value="00">Pilih tanggal</option>
                    <?php foreach ($option_waktu as $data): ?>
                        <option value="<?= $data->tgl_upd; ?>"><?= $data->tgl_upd; ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-primary ml-2">Filter</button>
                <a href="<?= base_url('resume/pengadaan-tanah/' . $slug); ?>" type="button" class="btn btn-warning ml-2">Reset</a>
            </form>

        </div>
    </div>
    <button
        class="btn btn-outline-warning float-right"
        onclick="edit(this)"
        data-id="<?= $jpn->id; ?>">
        <i class="fi fi-tr-file-edit"></i>
    </button>
    <div class="row">
        <!-- Area Chart -->
      <div class="col-xl-8">
    <!-- TOTAL KEBUTUHAN LAHAN -->
    <div class="card shadow mb-4 bg-secondary">
        <div class="card-body text-center text-white">
            <i class="fi fi-tr-land-layers fa-2x mb-2 d-block"></i>
            <p class="mb-1">Total Kebutuhan Lahan</p>
            <h6 class="font-weight-bold"><?= $jpn->total_kebutuhan_lahan ?></h6>
        </div>
    </div>

    <!-- TOTAL LAHAN SUDAH BEBAS -->
    <div class="card shadow mb-4 bg-success">
        <div class="card-body text-center text-white">
            <i class="fi fi-tr-check-circle fa-2x mb-2 d-block"></i>
            <p class="mb-1">Total Lahan Sudah Bebas</p>
            <h6 class="font-weight-bold"><?= $jpn->total_lahan_sudah_bebas ?></h6>
        </div>
    </div>

    <!-- TOTAL LAHAN BELUM BEBAS -->
    <div class="card shadow mb-4 bg-warning">
        <div class="card-body text-center text-white">
            <i class="fi fi-tr-circle-xmark fa-2x mb-2 d-block"></i>
            <p class="mb-1">Total Lahan Belum Bebas</p>
            <h6 class="font-weight-bold"><?= $jpn->total_lahan_belum_bebas ?></h6>
        </div>
    </div>
</div>


    <?php endforeach; ?>
    <div class="col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php if (user()->username == 'admin') : ?>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#tambahPaket">
            Tambah Paket <i class="fa fa-plus"></i>
        </button>
    <?php endif; ?>
    <div class="row mb-4 mt-2">
        <?php
        foreach ($tanah_data as $tnh):
        ?>
            <div class="col-md-4 mb-2">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center font-weight-bold"><?= $tnh->nama_paket; ?> <?php if (user()->username == 'admin') : ?>
                            <button class="btn btn-sm btn-warning float-right"
                                data-toggle="modal"
                                data-target="#editPaketTanah"
                                onclick="editpaket(this)"
                                data-id="<?= esc($tnh->id); ?>">
                                 <i class="fi fi-tr-file-edit"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p>Kebutuhan Lahan <span class="font-weight-bold"><?= $tnh->kebutuhan_lahan; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->kebutuhan_lahan_value; ?>%;" aria-valuenow="<?= $tnh->kebutuhan_lahan_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->kebutuhan_lahan_value; ?> %
                            </div>
                        </div>
                        <br>
                        <p>Sudah Bebas <span class="font-weight-bold"><?= $tnh->sdh_bbs; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $tnh->sdh_bbs_value; ?>%;" aria-valuenow="<?= $tnh->sdh_bbs_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->sdh_bbs_value; ?> %
                            </div>
                        </div>

                        <br>
                        <p>Belum Bebas <span class="font-weight-bold"><?= $tnh->blm_bebas; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $tnh->sdh_bbs_value; ?>%;" aria-valuenow="<?= $tnh->sdh_bbs_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->sdh_bbs_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Siap Bayar <span class="font-weight-bold"><?= $tnh->siap_byr; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->siap_byr; ?>%;" aria-valuenow="<?= $tnh->siap_bayar_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->siap_bayar_value; ?>%
                            </div>
                        </div>
                        <br>
                        <br>
                        <p>Konsinyasi <span class="font-weight-bold"><?= $tnh->konsinyasi; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $tnh->konsinyasi_value; ?>%;" aria-valuenow="<?= $tnh->konsinyasi_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->konsinyasi_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Pihak Akan Diundang Kembali <span class="font-weight-bold"><?= $tnh->phk_undang; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->phk_undang_value; ?>%;" aria-valuenow="<?= $tnh->phk_undang_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->phk_undang_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Proses Penilaian KJPP <span class="font-weight-bold"><?= $tnh->konsinyasi; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->konsinyasi_value; ?>%;" aria-valuenow="<?= $tnh->konsinyasi_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->konsinyasi_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Sudah Pengumuman <span class="font-weight-bold"><?= $tnh->sdh_pengumuman; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->sdh_pengumuman_value; ?>%;" aria-valuenow="<?= $tnh->sdh_pengumuman_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->sdh_pengumuman_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Belum Pengumuman <span class="font-weight-bold"><?= $tnh->blm_pengumuman; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->blm_pengumuman_value; ?>%;" aria-valuenow="<?= $tnh->blm_pengumuman_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->blm_pengumuman_value; ?>%
                            </div>
                        </div>
                        <br>
                        <p>Tanah Karakteristik Khusus<span class="font-weight-bold"><?= $tnh->tanah_karakteristik; ?></span></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $tnh->tanah_karakteristik_value; ?>%;" aria-valuenow="<?= $tnh->tanah_karakteristik_value; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $tnh->tanah_karakteristik_value; ?>%
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



    <!-- Modal Edit Data Pelaksanaan -->
    <div class="modal fade" id="editDataPengadaanTnh" tabindex="-1" role="dialog" aria-labelledby="editDataPengadaanTnhLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editDataPengadaanTnhLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id"> <!-- Hidden input to store the ID -->
                    <div class="form-group">
                        <label for="tgl_upd">Tanggal Progress</label>
                        <input type="date" name="tgl_upd" class="form-control" id="edit-tgl_upd">
                    </div>
                    <div class="form-group">
                        <label for="total_kebutuhan_lahan">Total Kebutuhan Lahan</label>
                        <input type="text" name="total_kebutuhan_lahan" class="form-control" id="edit-total_kebutuhan_lahan">
                    </div>
                    <div class="form-group">
                        <label for="total_lahan_sudah_bebas">Total Sudah Bebas (Bidang)</label>
                        <input type="text" name="total_lahan_sudah_bebas" class="form-control" id="edit-total_lahan_sudah_bebas">
                    </div>
                    <div class="form-group">
                        <label for="total_lahan_belum_bebas">Total Lahan Belum Bebas (Bidang)</label>
                        <input type="text" name="total_lahan_belum_bebas" class="form-control" id="edit-total_lahan_belum_bebas">
                    </div>
                    <div class="form-group">
                        <label for="total_lahan_sudah_bebas_value">Total Lahan Sudah Bebas (%)</label>
                        <input type="text" name="total_lahan_bebas_value" class="form-control" id="edit-total_lahan_bebas_value">
                    </div>
                    <div class="form-group">
                        <label for="total_lahan_belum_bebas">Total Lahan Belum Bebas (%)</label>
                        <input type="text" name="total_lahan_belum_bebas_value" class="form-control" id="edit-total_lahan_belum_bebas_value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Edit Data Pelaksanaan -->
    <div class="modal fade" id="editPaketTanah" tabindex="-1" role="dialog" aria-labelledby="editPaketTanahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editPaketTanahLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paket-id"> <!-- Hidden input to store the ID -->
                    <div class="form-group">
                        <label for="tgl_upd">Tanggal Progress</label>
                        <input type="date" name="tgl_upd" class="form-control" id="paket-tgl_upd">
                    </div>

                    <div class="form-group">
                        <label for="nama_paket">Total Kebutuhan Lahan</label>
                        <input type="text" name="nama_paket" class="form-control" id="paket-nama_paket">
                    </div>

                    <!-- Additional fields -->
                    <div class="form-group">
                        <label for="kebutuhan_lahan">Kebutuhan Lahan</label>
                        <input type="text" name="kebutuhan_lahan" class="form-control" id="paket-kebutuhan_lahan">
                    </div>
                    <div class="form-group">
                        <label for="kebutuhan_lahan_value">Kebutuhan Lahan Value</label>
                        <input type="text" name="kebutuhan_lahan_value" class="form-control" id="paket-kebutuhan_lahan_value">
                    </div>
                    <div class="form-group">
                        <label for="sdh_bbs">Sudah Bebas</label>
                        <input type="text" name="sdh_bbs" class="form-control" id="paket-sdh_bbs">
                    </div>
                    <div class="form-group">
                        <label for="sdh_bbs_value">Sudah Bebas Value</label>
                        <input type="text" name="sdh_bbs_value" class="form-control" id="paket-sdh_bbs_value">
                    </div>
                    <div class="form-group">
                        <label for="blm_bebas">Belum Bebas</label>
                        <input type="text" name="blm_bebas" class="form-control" id="paket-blm_bebas">
                    </div>
                    <div class="form-group">
                        <label for="blm_bebas_value">Belum Bebas Value</label>
                        <input type="text" name="blm_bebas_value" class="form-control" id="paket-blm_bebas_value">
                    </div>
                    <div class="form-group">
                        <label for="siap_byr">Siap Bayar</label>
                        <input type="text" name="siap_byr" class="form-control" id="paket-siap_byr">
                    </div>
                    <div class="form-group">
                        <label for="siap_bayar_value">Siap Bayar Value</label>
                        <input type="text" name="siap_bayar_value" class="form-control" id="paket-siap_bayar_value">
                    </div>
                    <div class="form-group">
                        <label for="konsinyasi">Konsinyasi</label>
                        <input type="text" name="konsinyasi" class="form-control" id="paket-konsinyasi">
                    </div>
                    <div class="form-group">
                        <label for="konsinyasi_value">Konsinyasi Value</label>
                        <input type="text" name="konsinyasi_value" class="form-control" id="paket-konsinyasi_value">
                    </div>
                    <div class="form-group">
                        <label for="phk_undang">PHK Undang</label>
                        <input type="text" name="phk_undang" class="form-control" id="paket-phk_undang">
                    </div>
                    <div class="form-group">
                        <label for="phk_undang_value">PHK Undang Value</label>
                        <input type="text" name="phk_undang_value" class="form-control" id="paket-phk_undang_value">
                    </div>
                    <div class="form-group">
                        <label for="proses_penilaian_kjpp">Proses Penilaian KJPP</label>
                        <input type="text" name="proses_penilaian_kjpp" class="form-control" id="paket-proses_penilaian_kjpp">
                    </div>
                    <div class="form-group">
                        <label for="proses_penilaian_kjpp_value">Proses Penilaian KJPP Value</label>
                        <input type="text" name="proses_penilaian_kjpp_value" class="form-control" id="paket-proses_penilaian_kjpp_value">
                    </div>
                    <div class="form-group">
                        <label for="sdh_pengumuman">Sudah Pengumuman</label>
                        <input type="text" name="sdh_pengumuman" class="form-control" id="paket-sdh_pengumuman">
                    </div>
                    <div class="form-group">
                        <label for="sdh_pengumuman_value">Sudah Pengumuman Value</label>
                        <input type="text" name="sdh_pengumuman_value" class="form-control" id="paket-sdh_pengumuman_value">
                    </div>
                    <div class="form-group">
                        <label for="blm_pengumuman">Belum Pengumuman</label>
                        <input type="text" name="blm_pengumuman" class="form-control" id="paket-blm_pengumuman">
                    </div>
                    <div class="form-group">
                        <label for="blm_pengumuman_value">Belum Pengumuman Value</label>
                        <input type="text" name="blm_pengumuman_value" class="form-control" id="paket-blm_pengumuman_value">
                    </div>
                    <div class="form-group">
                        <label for="tanah_karakteristik">Tanah Karakteristik</label>
                        <input type="text" name="tanah_karakteristik" class="form-control" id="paket-tanah_karakteristik">
                    </div>
                    <div class="form-group">
                        <label for="tanah_karakteristik_value">Tanah Karakteristik Value</label>
                        <input type="text" name="tanah_karakteristik_value" class="form-control" id="paket-tanah_karakteristik_value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateDataPaket()">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="tambahPengadaanTanah" tabindex="-1" role="dialog" aria-labelledby="tambahPengadaanTanahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tambahPengadaanTanahLabel">Tambah Resume Pengadaan Tanah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Ditjen</label>
                        <select class="form-control" name="jenis_main_id" id="tpt-jenis_main_id">
                            <?php foreach ($ditjen as $dtj): ?>
                                <option value="<?= $dtj->id; ?>"><?= $dtj->nama_jenis; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Total Kebutuhan Lahan</label>
                        <input type="text" name="total_kebutuhan_lahan" class="form-control" id="tpt-total_kebutuhan_lahan">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Total Lahan Sudah Bebas (Bidang)</label>
                        <input type="text" name="total_lahan_sudah_bebas" class="form-control" id="tpt-total_lahan_sudah_bebas">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Total Lahan Belum Bebas (Bidang)</label>
                        <input type="text" name="total_lahan_belum_bebas" class="form-control" id="tpt-total_lahan_belum_bebas">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Total Lahan Sudah Bebas (%)</label>
                        <input type="text" name="total_lahan_bebas_value" class="form-control" id="tpt-total_lahan_bebas_value">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Total Lahan Belum Bebas (%)</label>
                        <input type="text" name="total_lahan_belum_bebas_value" class="form-control" id="tpt-total_lahan_belum_bebas_value">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tanggal Update</label>
                        <input type="date" name="tgl_upd" class="form-control" id="tpt-tgl_upd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savePengadaanTanah()">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="tambahPaket" tabindex="-1" role="dialog" aria-labelledby="tambahPaketLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tambahPaketLabel">Tambah Paket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_pengadaan_tanah_id">Jenis Pengadaan Tanah</label>
                                <select class="form-control" name="jenis_pengadaan_tanah_id" id="jenis_pengadaan_tanah_id">
                                    <?php foreach ($jenis_pengadaan as $dtj): ?>
                                        <option value="<?= $dtj->id; ?>"><?= $dtj->total_kebutuhan_lahan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kebutuhan_lahan">Kebutuhan Lahan</label>
                                <input type="text" class="form-control" id="kebutuhan_lahan" name="kebutuhan_lahan">
                            </div>
                            <div class="form-group">
                                <label for="sdh_bbs">Sudah Bebas</label>
                                <input type="text" class="form-control" id="sdh_bbs" name="sdh_bbs">
                            </div>
                            <div class="form-group">
                                <label for="blm_bebas">Belum Bebas</label>
                                <input type="text" class="form-control" id="blm_bebas" name="blm_bebas">
                            </div>
                            <div class="form-group">
                                <label for="siap_byr">Siap Bayar</label>
                                <input type="text" class="form-control" id="siap_byr" name="siap_byr">
                            </div>
                            <div class="form-group">
                                <label for="konsinyasi">Konsinyasi</label>
                                <input type="text" class="form-control" id="konsinyasi" name="konsinyasi">
                            </div>
                            <div class="form-group">
                                <label for="phk_undang">PHK Undang</label>
                                <input type="text" class="form-control" id="phk_undang" name="phk_undang">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama_paket">Nama Paket</label>
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket">
                            </div>
                            <div class="form-group">
                                <label for="kebutuhan_lahan_value">Kebutuhan Lahan Value</label>
                                <input type="text" class="form-control" id="kebutuhan_lahan_value" name="kebutuhan_lahan_value">
                            </div>
                            <div class="form-group">
                                <label for="sdh_bbs_value">Sudah Bebas Value</label>
                                <input type="text" class="form-control" id="sdh_bbs_value" name="sdh_bbs_value">
                            </div>
                            <div class="form-group">
                                <label for="blm_bebas_value">Belum Bebas Value</label>
                                <input type="text" class="form-control" id="blm_bebas_value" name="blm_bebas_value">
                            </div>
                            <div class="form-group">
                                <label for="siap_bayar_value">Siap Bayar Value</label>
                                <input type="text" class="form-control" id="siap_bayar_value" name="siap_bayar_value">
                            </div>
                            <div class="form-group">
                                <label for="konsinyasi_value">Konsinyasi Value</label>
                                <input type="text" class="form-control" id="konsinyasi_value" name="konsinyasi_value">
                            </div>
                            <div class="form-group">
                                <label for="phk_undang_value">PHK Undang Value</label>
                                <input type="text" class="form-control" id="phk_undang_value" name="phk_undang_value">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proses_penilaian_kjpp">Proses Penilaian KJPP</label>
                                <input type="text" class="form-control" id="proses_penilaian_kjpp" name="proses_penilaian_kjpp">
                            </div>
                            <div class="form-group">
                                <label for="proses_penilaian_kjpp_value">Proses Penilaian KJPP Value</label>
                                <input type="text" class="form-control" id="proses_penilaian_kjpp_value" name="proses_penilaian_kjpp_value">
                            </div>
                            <div class="form-group">
                                <label for="sdh_pengumuman">Sudah Pengumuman</label>
                                <input type="text" class="form-control" id="sdh_pengumuman" name="sdh_pengumuman">
                            </div>
                            <div class="form-group">
                                <label for="sdh_pengumuman_value">Sudah Pengumuman Value</label>
                                <input type="text" class="form-control" id="sdh_pengumuman_value" name="sdh_pengumuman_value">
                            </div>
                            <div class="form-group">
                                <label for="blm_pengumuman">Belum Pengumuman</label>
                                <input type="text" class="form-control" id="blm_pengumuman" name="blm_pengumuman">
                            </div>
                            <div class="form-group">
                                <label for="blm_pengumuman_value">Belum Pengumuman Value</label>
                                <input type="text" class="form-control" id="blm_pengumuman_value" name="blm_pengumuman_value">
                            </div>
                            <div class="form-group">
                                <label for="tanah_karakteristik">Tanah Karakteristik</label>
                                <input type="text" class="form-control" id="tanah_karakteristik" name="tanah_karakteristik">
                            </div>
                            <div class="form-group">
                                <label for="tanah_karakteristik_value">Tanah Karakteristik Value</label>
                                <input type="text" class="form-control" id="tanah_karakteristik_value" name="tanah_karakteristik_value">
                            </div>
                            <div class="form-group">
                                <label for="tgl_upd">Tanggal Update</label>
                                <input type="date" class="form-control" id="tgl_upd" name="tgl_upd">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savePaketPengadaan()">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="tambahMasalahPercepatan" tabindex="-1" role="dialog" aria-labelledby="tambahMasalahPercepatanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tambahMasalahPercepatanLabel">Tambah Masalah Percepatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pengadaan_tanah_id">Jenis Pengadaan Tanah</label>
                        <select class="form-control" name="jenis_pengadaan_tanah_id" id="jenis_pengadaan_tanah_id">
                            <?php foreach ($jenis_pengadaan as $dtj): ?>
                                <option value="<?= $dtj->id; ?>"><?= $dtj->total_kebutuhan_lahan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" id="nama_paket">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Status</label>
                        <input type="text" name="status" class="form-control" id="status">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Kendala</label>
                        <input type="text" name="kendala" class="form-control" id="kendala">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tindak Lanjut</label>
                        <input type="text" name="tindak_lanjut" class="form-control" id="tindak_lanjut">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveMasalah()">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Data Pelaksanaan -->
    <div class="modal fade" id="editMasalah" tabindex="-1" role="dialog" aria-labelledby="editMasalahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editMasalahLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="msl-id"> <!-- Hidden input to store the ID -->
                    <div class="form-group">
                        <label for="nama_paket">Nama Paket</label>
                        <input type="date" name="nama_paket" class="form-control" id="msl-nama_paket">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <textarea name="status" class="form-control" id="msl-status"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kendala">Kendala</label>
                        <textarea name="kendala" class="form-control" id="msl-kendala"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tindak_lanjut">Tindak Lanjut</label>
                        <textarea name="tindak_lanjut" class="form-control" id="msl-tindak_lanjut"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <?php if (user()->username == 'admin') : ?>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#tambahMasalahPercepatan">
            Tambah Masalah Percepatan <i class="fa fa-plus"></i>
        </button>
    <?php endif; ?>
    <table id="example" class="display" style="width:100%">
        <thead class="bg bg-primary text-white text-center">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Paket</th>
                <th class="text-center">Status</th>
                <th class="text-center">Kendala</th>
                <th class="text-center">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($masalah_percepatan as $msl) { ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td>
                        <?php if (user()->username == 'admin') : ?>
                            <br>
                            <button class="btn btn-sm btn-outline-warning float-right"
                                data-toggle="modal"
                                data-target="#editMasalah"
                                onclick="editmasalah(this)"
                                data-id="<?= esc($msl->id); ?>">
                                 <i class="fi fi-tr-file-edit"></i>
                            </button>
                        <?php endif; ?>
                        <?= $msl->nama_paket; ?>
                    </td>
                    <td>
                        <?= $msl->status; ?>
                    </td>
                    <td>
                        <?= $msl->kendala; ?>
                    </td>
                    <td>
                        <?= $msl->tindak_lanjut; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                order: [
                    [0, 'asc']
                ], // Default sorting on the first column
                lengthMenu: [10, 25, 50, 100], // Options for number of records per page
                pageLength: 10 // Default number of records per page
            });
        });

        document.getElementById('resetButton').addEventListener('click', function() {
            location.reload(); // Reload halaman saat ini
        });

        function updateData() {
            var id = document.getElementById("edit-id").value;
            var tgl_upd = $("#edit-tgl_upd").val();
            var total_kebutuhan_lahan = $("#edit-total_kebutuhan_lahan").val();
            var total_lahan_sudah_bebas = $("#edit-total_lahan_sudah_bebas").val();
            var total_lahan_belum_bebas = $("#edit-total_lahan_belum_bebas").val();
            var total_lahan_bebas_value = $("#edit-total_lahan_bebas_value").val();
            var total_lahan_belum_bebas_value = $("#edit-total_lahan_belum_bebas_value").val();

            // AJAX request to save data
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>updatePengadaanTanah', // Adjust as needed for your update endpoint
                data: {
                    id: id,
                    tgl_upd: tgl_upd,
                    total_kebutuhan_lahan: total_kebutuhan_lahan,
                    total_lahan_sudah_bebas: total_lahan_sudah_bebas,
                    total_lahan_belum_bebas: total_lahan_belum_bebas,
                    total_lahan_bebas_value: total_lahan_bebas_value,
                    total_lahan_belum_bebas_value: total_lahan_belum_bebas_value,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#editDataPengadaanTnh').modal('hide');
                        // Optionally refresh data or update UI
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                        confirmButtonText: 'OK'
                    });

                }
            });
        }


        function edit(elem) {
            var dataId = $(elem).data("id");
            document.getElementById("edit-id").setAttribute('value', dataId);
            $('#editDataPengadaanTnh').modal();
            $.ajax({
                type: 'GET',
                url: '<?= base_url() ?>detailPengadaanTnh',
                data: 'id=' + dataId,
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Check the data in the console
                    $.each(response, function(i, item) {
                        document.getElementById("edit-tgl_upd").value = item.tgl_upd;
                        document.getElementById("edit-total_kebutuhan_lahan").value = item.total_kebutuhan_lahan;
                        document.getElementById("edit-total_lahan_sudah_bebas").value = item.total_lahan_sudah_bebas;
                        document.getElementById("edit-total_lahan_belum_bebas").value = item.total_lahan_belum_bebas;
                        document.getElementById("edit-total_lahan_belum_bebas_value").value = item.total_lahan_belum_bebas_value;
                        document.getElementById("edit-total_lahan_bebas_value").value = item.total_lahan_bebas_value;
                    });
                }


            });
            return false;
        }



        function editpaket(elem) {
            var dataId = $(elem).data("id");
            document.getElementById("paket-id").setAttribute('value', dataId);
            $('#editPaketTanah').modal();
            $.ajax({
                type: 'GET',
                url: '<?= base_url() ?>detailPaketTanah',
                data: 'id=' + dataId,
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Check the data in the console
                    $.each(response, function(i, item) {
                        document.getElementById("paket-tgl_upd").value = item.tgl_upd; // Tanggal Progress
                        document.getElementById("paket-nama_paket").value = item.nama_paket || ''; // Nama Paket
                        document.getElementById("paket-kebutuhan_lahan").value = item.kebutuhan_lahan || ''; // Kebutuhan Lahan
                        document.getElementById("paket-kebutuhan_lahan_value").value = item.kebutuhan_lahan_value || ''; // Kebutuhan Lahan Value
                        document.getElementById("paket-sdh_bbs").value = item.sdh_bbs || ''; // Sudah Bebas
                        document.getElementById("paket-sdh_bbs_value").value = item.sdh_bbs_value || ''; // Sudah Bebas Value
                        document.getElementById("paket-blm_bebas").value = item.blm_bebas || ''; // Belum Bebas
                        document.getElementById("paket-blm_bebas_value").value = item.blm_bebas_value || ''; // Belum Bebas Value
                        document.getElementById("paket-siap_byr").value = item.siap_byr || ''; // Siap Bayar
                        document.getElementById("paket-siap_bayar_value").value = item.siap_bayar_value || ''; // Siap Bayar Value
                        document.getElementById("paket-konsinyasi").value = item.konsinyasi || ''; // Konsinyasi
                        document.getElementById("paket-konsinyasi_value").value = item.konsinyasi_value || ''; // Konsinyasi Value
                        document.getElementById("paket-phk_undang").value = item.phk_undang || ''; // PHK Undang
                        document.getElementById("paket-phk_undang_value").value = item.phk_undang_value || ''; // PHK Undang Value
                        document.getElementById("paket-proses_penilaian_kjpp").value = item.proses_penilaian_kjpp || ''; // Proses Penilaian KJPP
                        document.getElementById("paket-proses_penilaian_kjpp_value").value = item.proses_penilaian_kjpp_value || ''; // Proses Penilaian KJPP Value
                        document.getElementById("paket-sdh_pengumuman").value = item.sdh_pengumuman || ''; // Sudah Pengumuman
                        document.getElementById("paket-sdh_pengumuman_value").value = item.sdh_pengumuman_value || ''; // Sudah Pengumuman Value
                        document.getElementById("paket-blm_pengumuman").value = item.blm_pengumuman || ''; // Belum Pengumuman
                        document.getElementById("paket-blm_pengumuman_value").value = item.blm_pengumuman_value || ''; // Belum Pengumuman Value
                        document.getElementById("paket-tanah_karakteristik").value = item.tanah_karakteristik || ''; // Tanah Karakteristik
                        document.getElementById("paket-tanah_karakteristik_value").value = item.tanah_karakteristik_value || ''; // Tanah Karakteristik Value
                    });
                }


            });
            return false;
        }




        function updateDataPaket() {
            var id = document.getElementById("paket-id").value; // Adjusted to match the hidden input ID
            var tgl_upd = $("#paket-tgl_upd").val(); // Updated selector
            var total_kebutuhan_lahan = $("#paket-nama_paket").val(); // Assuming this is what you want for total kebutuhan lahan
            var total_lahan_sudah_bebas = $("#paket-sdh_bbs").val(); // Updated selector
            var total_lahan_belum_bebas = $("#paket-blm_bebas").val(); // Updated selector
            var total_lahan_bebas_value = $("#paket-sdh_bbs_value").val(); // Updated selector
            var total_lahan_belum_bebas_value = $("#paket-blm_bebas_value").val(); // Updated selector
            var siap_bayar = $("#paket-siap_byr").val(); // New field
            var siap_byr_value = $("#paket-siap_byr_value").val();
            var konsinyasi = $("#paket-konsinyasi").val(); // New field
            var konsinyasi_value = $("#paket-konsinyasi_value").val(); // New field
            var phk_undang = $("#paket-phk_undang").val();
            var phk_undang_value = $("#paket-phk_undang_value").val(); // New field
            var proses_penilaian_kjpp = $("#paket-proses_penilaian_kjpp").val();
            var proses_penilaian_kjpp_value = $("#paket-proses_penilaian_kjpp_value").val(); // New field
            var sdh_pengumuman = $("#paket-sdh_pengumuman").val();
            var sdh_pengumuman_value = $("#paket-sdh_pengumuman_value").val(); // New field
            var blm_pengumuman = $("#paket-blm_pengumuman").val();
            var blm_pengumuman_value = $("#paket-blm_pengumuman_value").val(); // New field
            var tanah_karakteristik = $("#paket-tanah_karakteristik").val();
            var tanah_karakteristik_value = $("#paket-tanah_karakteristik_value").val(); // New field

            // AJAX request to save data
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>updateDataPaket', // Adjust as needed for your update endpoint
                data: {
                    id: id,
                    tgl_upd: tgl_upd,
                    total_kebutuhan_lahan: total_kebutuhan_lahan,
                    total_lahan_sudah_bebas: total_lahan_sudah_bebas,
                    total_lahan_belum_bebas: total_lahan_belum_bebas,
                    total_lahan_bebas_value: total_lahan_bebas_value,
                    total_lahan_belum_bebas_value: total_lahan_belum_bebas_value,
                    siap_bayar: siap_bayar,
                    siap_byr_value: siap_byr_value, // New field
                    konsinyasi: konsinyasi,
                    konsinyasi_value: konsinyasi_value, // New field
                    phk_undang: phk_undang,
                    phk_undang_value: phk_undang_value, // New field
                    proses_penilaian_kjpp: proses_penilaian_kjpp,
                    proses_penilaian_kjpp_value: proses_penilaian_kjpp_value, // New field
                    sdh_pengumuman: sdh_pengumuman,
                    sdh_pengumuman_value: sdh_pengumuman_value, // New field
                    blm_pengumuman: blm_pengumuman,
                    blm_pengumuman_value: blm_pengumuman_value, // New field
                    tanah_karakteristik: tanah_karakteristik,
                    tanah_karakteristik_value: tanah_karakteristik_value // New field
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Close the modal
                        $('#editPaketTanah').modal('hide'); // Updated modal ID
                        // Optionally refresh data or update UI
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }



        function savePengadaanTanah() {
            $.ajax({
                url: '<?= base_url(); ?>storePengadaanTanah', // Replace with your actual endpoint
                method: 'POST',
                data: {
                    jenis_main_id: $('#tpt-jenis_main_id').val(),
                    total_kebutuhan_lahan: $('#tpt-total_kebutuhan_lahan').val(),
                    total_lahan_sudah_bebas: $('#tpt-total_lahan_sudah_bebas').val(),
                    total_lahan_belum_bebas: $('#tpt-total_lahan_belum_bebas').val(),
                    total_lahan_bebas_value: $('#tpt-total_lahan_bebas_value').val(),
                    total_lahan_belum_bebas_value: $('#tpt-total_lahan_belum_bebas_value').val(),
                    tgl_upd: $('#tpt-tgl_upd').val(),
                },
                dataType: 'json', // Ensures the response is treated as JSON
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tambahPengadaanTanah').modal('hide');
                            // Optional: Refresh the data on the page or redirect
                        });
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan dalam menyimpan data.',
                        confirmButtonText: 'OK'
                    });

                }
            });
        }

        function saveMasalah() {
            $.ajax({
                url: '<?= base_url(); ?>storeMasalahPercepatan', // Replace with your actual endpoint
                method: 'POST',
                data: {
                    jenis_pengadaan_tanah_id: $('select[name="jenis_pengadaan_tanah_id"]').val(),
                    nama_paket: $('input[name="nama_paket"]').val(),
                    status: $('input[name="status"]').val(),
                    kendala: $('input[name="kendala"]').val(),
                    tindak_lanjut: $('input[name="tindak_lanjut"]').val(),
                },
                dataType: 'json', // Ensures the response is treated as JSON
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tambahMasalahPercepatan').modal('hide');
                            // Optional: Refresh the data on the page or redirect
                        });
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan dalam menyimpan data.',
                        confirmButtonText: 'OK'
                    });

                }
            });
        }


        function editmasalah(elem) {
            var dataId = $(elem).data("id");
            document.getElementById("msl-id").setAttribute('value', dataId);
            $('#editMasalah').modal();
            $.ajax({
                type: 'GET',
                url: '<?= base_url() ?>detailMasalahPercepatan',
                data: 'id=' + dataId,
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Check the data in the console
                    $.each(response, function(i, item) {
                        document.getElementById("msl-nama_paket").value = item.nama_paket; // Tanggal Progress
                        document.getElementById("msl-status").value = item.status || ''; // Nama Paket
                        document.getElementById("msl-kendala").value = item.kendala || ''; // Kebutuhan Lahan
                        document.getElementById("msl-tindak_lanjut").value = item.tindak_lanjut || ''; // Kebutuhan Lahan Value
                    });
                }

            });
            return false;
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#myTable').DataTable({
                "rowGroup": {
                    "dataSrc": 0 // Group by the first column (Bulan)
                },
                "order": [
                    [1, 'asc']
                ], // Sort by Tanggal
                "language": {
                    "emptyTable": "Tidak ada data tersedia", // Message when there is no data
                    "zeroRecords": "Data tidak ditemukan" // Message for search with no results
                }
            });

            // Check if the table has any data
            if (table.data().count() === 0) {
                // Hide the table if no data is present
                $('#myTable').hide();
                // Optionally, show a message to inform the user
                $('#noDataMessage').show(); // Make sure to create an element for this
            } else {
                $('#noDataMessage').hide(); // Hide the message if data is present
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#msl-status, #msl-kendala, #msl-tindak_lanjut',
                menubar: false, // Hide the menu bar for a cleaner look
                plugins: 'lists link image table code', // Include additional plugins if needed
                toolbar: 'undo redo | bold italic | bullist numlist | alignleft aligncenter alignright | code', // Customize the toolbar buttons
                height: 300 // Set a height for the editor
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Lahan Belum Bebas', 'Total Lahan Bebas'],
                datasets: [{
                    label: 'My Pie Chart',
                    data: [
                        <?php
                        foreach ($jenis_pengadaan as $tnh) {
                            echo $tnh->total_lahan_belum_bebas_value . ',' . $tnh->total_lahan_bebas_value;
                        }
                        ?>
                    ],
                    backgroundColor: ['rgba(54, 162, 235, 1)', 'rgba(242, 147, 5, 1)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(242, 147, 5, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'center', // Align the legend to the center
                        labels: {
                            font: {
                                family: 'Montserrat', // Set the legend font to Montserrat
                                size: 12,
                                weight: 'normal'
                            },
                            usePointStyle: true, // Use point style for better alignment
                            boxWidth: 10 // Adjust the box size for better spacing
                        }
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            family: 'Montserrat',
                            weight: 'bold'
                        },
                        formatter: (value) => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });



        function savePaketPengadaan() {
            $.ajax({
                url: '<?= base_url(); ?>storePaketPengadaan', // Replace with your actual endpoint
                method: 'POST',
                data: {
                    jenis_pengadaan_tanah_id: $('select[name="jenis_pengadaan_tanah_id"]').val(),
                    nama_paket: $('input[name="nama_paket"]').val(),
                    kebutuhan_lahan: $('input[name="kebutuhan_lahan"]').val(),
                    kebutuhan_lahan_value: $('input[name="kebutuhan_lahan_value"]').val(),
                    sdh_bbs: $('input[name="sdh_bbs"]').val(),
                    sdh_bbs_value: $('input[name="sdh_bbs_value"]').val(),
                    blm_bebas: $('input[name="blm_bebas"]').val(),
                    blm_bebas_value: $('input[name="blm_bebas_value"]').val(),
                    siap_byr: $('input[name="siap_byr"]').val(),
                    siap_bayar_value: $('input[name="siap_bayar_value"]').val(),
                    konsinyasi: $('input[name="konsinyasi"]').val(),
                    konsinyasi_value: $('input[name="konsinyasi_value"]').val(),
                    phk_undang: $('input[name="phk_undang"]').val(),
                    phk_undang_value: $('input[name="phk_undang_value"]').val(),
                    proses_penilaian_kjpp: $('input[name="proses_penilaian_kjpp"]').val(),
                    proses_penilaian_kjpp_value: $('input[name="proses_penilaian_kjpp_value"]').val(),
                    sdh_pengumuman: $('input[name="sdh_pengumuman"]').val(),
                    sdh_pengumuman_value: $('input[name="sdh_pengumuman_value"]').val(),
                    blm_pengumuman: $('input[name="blm_pengumuman"]').val(),
                    blm_pengumuman_value: $('input[name="blm_pengumuman_value"]').val(),
                    tanah_karakteristik: $('input[name="tanah_karakteristik"]').val(),
                    tanah_karakteristik_value: $('input[name="tanah_karakteristik_value"]').val(),
                    tgl_upd: $('input[name="tgl_upd"]').val(),
                },
                dataType: 'json', // Ensures the response is treated as JSON
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tambahPengadaanTanah').modal('hide');
                            // Optional: Refresh the data on the page or redirect
                        });
                        window.setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan dalam menyimpan data.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>





    <?= $this->endSection() ?>
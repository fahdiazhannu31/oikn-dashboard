<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Content Row -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Tombol Update Data Pelaksanaan di sebelah kiri -->
    <?php if (user()->username == 'admin') : ?>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
            Update Data Pelaksanaan <i class="fa fa-plus"></i>
        </button>
    <?php endif; ?>
    <!-- Input filter dan tombol filter di sebelah kanan -->
    <div class="d-flex align-items-center">
        <form method="get" action="<?= base_url('progress/pelaksanaan'); ?>" class="d-flex justify-content-end">
            <select name="tgl_upd" id="tgl_upd" class="form-control me-2">
                <option value="00">Pilih tanggal</option>
                <?php foreach ($option_waktu as $data): ?>
                    <option value="<?php echo $data->tgl_upd; ?>"><?php echo $data->tgl_upd; ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary ml-2">Filter</button>
            <a href="<?= base_url('progress/pelaksanaan'); ?>" class="btn btn-warning ml-2">Reset</a>
        </form>
    </div>
</div>
<?php foreach ($tgl_upd as $tgl): ?>
    <p class="text-left text-muted mb-2">
        Data upd :
        <?= date('F d, Y', strtotime($tgl)); ?>
    </p>
<?php endforeach; ?>
<div class="row mt-2">
    <!-- Earnings (Monthly) Card Example -->
    <?php foreach ($total as $ttl): ?>
        <div class="col-xl-12 col-md-3 mb-4">
            <div class="card card-dashboard h-100 py-2">
                <div class="card-body">
                    <?php if (user()->username == 'admin') : ?>
                      <button class="btn btn-sm btn-outline-warning"
                            onclick="edit(this)"
                            data-id="<?= esc($ttl->id); ?>">
                            <i class="fi fi-tr-file-edit"></i>
                        </button>
                    <?php endif; ?>
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-2xl font-weight-bold text-dark text-uppercase">
                                <?= $ttl->nama_batch; ?></div>
                            <div class="text-xs text-muted">
                                <?= $ttl->ket_1; ?>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-primary"><?= $ttl->jml_paket; ?></div>
                        </div>
                        <div class="col mr-2 mt-4">
                            <div class="text-xs text-dark text-uppercase">
                                <?= $ttl->ket_2; ?>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-success"><?= $ttl->total_pagu; ?></div>
                        </div>
                        <div class="col mr-2 mt-4">
                            <div class="text-xs text-dark text-uppercase">
                                <?= $ttl->ket_3; ?>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-success"><?= $ttl->progress_fisik; ?>%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Earnings (Monthly) Card Example -->
   <?php foreach ($pelaksanaan as $plk): ?>
<div class="col-xl-4 col-md-6 mb-4">
	<div class="card card-dashboard h-100">
	<div class="card-body">

		<div class="d-flex justify-content-between align-items-center mb-3">
			<div>
				<h6 class="mb-0 font-weight-bold text-uppercase">
					<?= $plk->nama_batch ?>
				</h6>
				<small class="text-muted"><?= $plk->ket_1 ?></small>
			</div>

			<?php if (user()->username == 'admin') : ?>
				<button class="btn btn-sm btn-outline-warning"
						data-toggle="modal"
						data-target="#editDataPelaksanaan"
						onclick="edit(this)"
						data-id="<?= esc($plk->id); ?>">
						<i class="fi fi-tr-file-edit"></i>
					</button>
			<?php endif; ?>
		</div>

		<div class="text-center mb-3">
			<div class="text-muted small">Jumlah Paket</div>
			<div class="display-4 font-weight-bold gradient-text">
				<?= $plk->jml_paket ?>
			</div>
		</div>

		<hr>

		<div class="row text-center">
			<div class="col-6">
				<div class="text-muted small">Pagu</div>
				<div class="font-weight-bold" style="color:#0984e3">
					<?= $plk->total_pagu ?>
				</div>
			</div>
			<div class="col-6">
				<div class="text-muted small">Progress</div>
				<div class="font-weight-bold" style="color:#00b894">
					<?= $plk->progress_fisik ?>%
				</div>
			</div>
		</div>

	</div>
</div>

</div>
<?php endforeach; ?>


</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php if (user()->username == 'admin') : ?>
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#resumeFisik">
                        Tambah Resume Fisik <i class="fa fa-plus"></i>
                    </button>
                    <table id="myTable2" class="table table-bordered">
	<thead class="bg-primary text-white">
		<tr>
			<th class="text-center">ID Fisik</th>
			<th class="text-center">Nama Batch</th>
			<th class="text-center">Nama Progress Fisik</th>
			<th class="text-center">Jumlah Progress</th>
			<th class="text-center">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($fisik)) : ?>
			<?php foreach ($fisik as $fsk) : ?>
				<tr>
					<td class="text-center"><?= esc($fsk->id_fisik) ?></td>
					<td><?= esc($fsk->nama_batch) ?></td>
					<td><?= esc($fsk->nama_progress_fisik) ?></td>
					<td class="text-center"><?= esc($fsk->jml_progress) ?></td>
					<td class="text-center">
						<button class="btn btn-sm btn-outline-warning mr-1"
							data-toggle="modal"
							data-target="#editdatafisik"
							onclick="editdatafisik(this)"
							data-id="<?= esc($fsk->id_fisik); ?>">
								<i class="fi fi-tr-file-edit"></i>
						</button>

						<button class="btn btn-sm btn-outline-danger"
							data-toggle="modal"
							data-target="#deleteDataPekerja"
							onclick="setDeleteId(<?= esc($fsk->id_fisik); ?>)">
						<i class="fi fi-tr-delete"></i>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
				<td colspan="5" class="text-center">Data tidak ditemukan</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#resumeBidang">
                        Tambah Resume Per Bidang <i class="fa fa-plus"></i>
                    </button>
                    <table id="myTable3" class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nama Bidang</th>
                                <th class="text-center">Batch</th>
                                <th class="text-center">Jumlah Paket</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($grafik)) : ?>
                                <?php foreach ($grafik as $bdg) : ?>
                                    <tr>
                                        <td class="text-center"><?= esc($bdg->id) ?></td>
                                        <td class="text-center"><?= esc($bdg->nama_bidang) ?></td>
                                        <td class="text-center"><?= esc($bdg->nama_batch) ?></td>
                                        <td class="text-center"><?= esc($bdg->jml_paket) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning"
                                                data-toggle="modal"
                                                data-target="#editdatabidang"
                                                onclick="editdatabidang(this)"
                                                data-id="<?= esc($bdg->id); ?>">
                                                	<i class="fi fi-tr-file-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                data-toggle="modal"
                                                data-target="#deleteDataPekerja"
                                                onclick="setDeleteId(<?= esc($bdg->id); ?>)">
                                                <i class="fi fi-tr-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>




    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Resume Progress Pelaksanaan</h5>
                <br>
                <?php if (user()->username == 'admin') : ?>
                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#resumePelaksanaan">
                        Tambah Resume Pelaksanaan <i class="fa fa-plus"></i>
                    </button>
                <?php endif; ?>

                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center text-white bg-primary">No</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">Unor</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">Nama Paket</th> <!-- Kolom utama -->
                            <th colspan="3" class="text-center text-white bg-primary">Progress Fisik MYC (%)</th> <!-- Kolom dengan sub-kolom -->
                            <th rowspan="2" class="text-center text-white bg-primary">Status</th> <!-- Kolom dengan sub-kolom -->
                            <th rowspan="2" class="text-center text-white bg-primary">Isu</th> <!-- Kolom dengan sub-kolom -->
                             <th rowspan="2" class="text-center text-white bg-primary">Aksi</th> <!-- Kolom dengan sub-kolom -->
                        </tr>
                        <tr>
                            <th class="text-center text-white bg-primary">Rencana</th>
                            <th class="text-center text-white bg-primary">Realisasi</th>
                            <th class="text-center text-white bg-primary">Deviasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($resume as $rsm) : ?>

                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td>
                                    <?= $rsm->unor; ?>
                                </td>
                                <td class="text-center"><?= $rsm->nama_paket; ?></td>
                                <td class="text-middle"><?= $rsm->rencana; ?> %</td>
                                <td class="text-middle"><?= $rsm->realisasi; ?> %</td>
                                <td class="text-middle"><?= $rsm->deviasi; ?> %</td>
                                <td class="text-middle <?= ($rsm->deviasi < 0) ? 'bg-overtime text-white' : '' ?>"><?= $rsm->status; ?></td>
                                <td><?= $rsm->isu; ?></td>
                               <td class="text-center">
    <?php if (user()->username == 'admin') : ?>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                type="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            </button>

            <div class="dropdown-menu dropdown-menu-right shadow-sm">
                <a class="dropdown-item"
                   href="javascript:void(0)"
                   data-toggle="modal"
                   data-target="#editDataResume"
                   onclick="editDataResume(this)"
                   data-id="<?= esc($rsm->id); ?>">
                    <i class="fi fi-tr-file-edit text-warning mr-2"></i> Edit
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger"
                   href="javascript:void(0)"
                   data-toggle="modal"
                   data-target="#deleteResumePelaksanaan"
                   onclick="deleteResumePlk(<?= esc($rsm->id); ?>)">
                    <i class="fi fi-tr-delete mr-2"></i> Hapus
                </a>
            </div>
        </div>
    <?php endif; ?>
</td>

                            </tr>
                        <?php endforeach; ?>
                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="editDataResume" tabindex="-1" role="dialog" aria-labelledby="editDataResumeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDataResumeLabel">Edit Data Pekerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rsm-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="unor">Unor</label>
                    <input type="text" name="unor" class="form-control" id="rsm-unor">
                </div>
                <div class="form-group">
                    <label for="nama_paket">Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control" id="rsm-nama_paket">
                </div>
                <div class="form-group">
                    <label for="rencana">Rencana</label>
                    <input type="text" name="rencana" class="form-control" id="rsm-rencana" oninput="calculateDeviasi2()">
                </div>
                <div class="form-group">
                    <label for="realisasi">Realisasi</label>
                    <input type="text" name="realisasi" class="form-control" id="rsm-realisasi" oninput="calculateDeviasi2()">
                </div>
                <div class=" form-group">
                    <label for="deviasi">Deviasi</label>
                    <input type="text" name="deviasi" class="form-control" id="rsm-deviasi" readonly>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" class="form-control" id="rsm-status">
                </div>
                <div class=" form-group">
                    <label for="isu">Isu</label>
                    <input type="text" name="isu" class="form-control" id="rsm-isu">
                </div>
                <div class="form-group">
                    <label for="tgl_data">Tanggal Update</label>
                    <input type="date" name="tgl_data" class="form-control" id="rsm-tgl_data">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateResume()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Update Data Pelaksanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Pilih Batch</label>
                    <select class="form-control" name="batch_id" aria-label="Default select example">
                        <option selected>Pilih Batch</option>
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="idd" id="id">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Keterangan 1</label>
                    <input type="text" name="ket_1" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Keterangan 2</label>
                    <input type="text" name="ket_2" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Keterangan 3</label>
                    <input type="text" name="ket_3" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Jumlah Paket</label>
                            <input type="text" name="jml_paket" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Total Pagu</label>
                            <input type="text" name="total_pagu" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Progress Fisik</label>
                            <input type="text" name="progress_fisik" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="exampleFormControlInput1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveData()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit Data Pelaksanaan -->
<div class="modal fade" id="editDataPelaksanaan" tabindex="-1" role="dialog" aria-labelledby="editDataPelaksanaanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDataPelaksanaanLabel">Edit Data Pelaksanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="batch_id">Batch</label>
                    <select data-plugin-selectTwo class="form-control" id="batch_id">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ket_1">Keterangan 1</label>
                    <input type="text" name="ket_1" class="form-control" id="ket_1">
                </div>
                <div class="form-group">
                    <label for="ket_2">Keterangan 2</label>
                    <input type="text" name="ket_2" class="form-control" id="ket_2">
                </div>
                <div class="form-group">
                    <label for="ket_3">Keterangan 3</label>
                    <input type="text" name="ket_3" class="form-control" id="ket_3">
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jml_paket">Jumlah Paket</label>
                            <input type="text" name="jml_paket" class="form-control" id="jml_paket">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total_pagu">Total Pagu</label>
                            <input type="text" name="total_pagu" class="form-control" id="total_pagu">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="progress_fisik">Progress Fisik</label>
                            <input type="text" name="progress_fisik" class="form-control" id="progress_fisik">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="resumePelaksanaan" tabindex="-1" role="dialog" aria-labelledby="resumePelaksanaanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resumePelaksanaanLabel">Tambah Resume Pelaksanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Unor</label>
                    <input type="text" name="trs-unor" class="form-control" id="trs-unor">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Paket</label>
                    <input type="text" name="trs-nama_paket" class="form-control" id="trs-nama_paket">
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Rencana</label>
                            <input type="number" step="0.01" name="trs-rencana" class="form-control" id="trs-rencana" oninput="calculateDeviasi()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Realisasi</label>
                            <input type="number" step="0.01" name="trs-realisasi" class="form-control" id="trs-realisasi" oninput="calculateDeviasi()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Devasi</label>
                            <input type="number" step="0.01" name="trs-deviasi" class="form-control" id="trs-deviasi">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Status</label>
                            <select class="form-control" name="trs-status" id="trs-status">
                                <option value="">Pilih Status</option>
                                <option value="On Time">On Time</option>
                                <option value="Terlambat">Terlambat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Isu</label>
                            <textarea name="trs-isu" class="form-control" id="trs-isu"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Tanggal Update</label>
                    <input type="date" name="trs-tgl_data" class="form-control" id="trs-tgl_data">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDataResume()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDataFisik" tabindex="-1" role="dialog" aria-labelledby="editDataFisikLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDataFisikLabel">Edit Data Fisik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="fsk-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="batch">Batch</label>
                    <select data-plugin-selectTwo class="form-control" name="batch_id" id="fsk-batch_id">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Fisik">Nama Fisik</label>
                    <select data-plugin-selectTwo class="form-control" name="fisik_progress_id" id="fsk-fisik_progress_id">
                        <?php foreach ($progress_perfisik as $pfk): ?>
                            <option value="<?= $pfk->id; ?>"><?= $pfk->nama_progress_fisik; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">Jumlah Progress</label>
                    <input type="text" name="jml_progress" class="form-control" id="fsk-jml_progress">
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="fsk-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateFisik()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="resumeFisik" tabindex="-1" role="dialog" aria-labelledby="resumeFisikLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resumeFisikLabel">Tambah Resume Fisik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="batch">Batch</label>
                    <select data-plugin-selectTwo class="form-control" name="rsf-batch_id" id="rsf-batch_id">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Fisik">Nama Fisik</label>
                    <select data-plugin-selectTwo class="form-control" name="rsf-fisik_progress_id" id="rsf-fisik_progress_id">
                        <?php foreach ($progress_perfisik as $pfk): ?>
                            <option value="<?= $pfk->id; ?>"><?= $pfk->nama_progress_fisik; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">Jumlah Progress</label>
                    <input type="text" name="rsf-jml_progress" class="form-control" id="rsf-jml_progress">
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="rsf-tgl_upd" class="form-control" id="rsf-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDataFisik()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteResumePelaksanaan" tabindex="-1" role="dialog" aria-labelledby="deleteResumePelaksanaanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteResumePelaksanaanLabel">Delete Data Pekerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this data?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger" onclick="deleteDataResume()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="resumeBidang" tabindex="-1" role="dialog" aria-labelledby="resumeBidangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resumeBidangLabel">Tambah Resume Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="batch">Batch</label>
                    <select data-plugin-selectTwo class="form-control" name="rsb-batch_id" id="rsb-batch_id">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Bidang">Nama Bidang</label>
                    <select data-plugin-selectTwo class="form-control" name="rsb-bidang_id" id="rsb-bidang_id">
                        <option value="1">Sumber Daya Air</option>
                        <option value="2">Bina Marga</option>
                        <option value="3">Cipta Karya</option>
                        <option value="4">Perumahan</option>
                    </select>
                </div>                <div class="form-group">Jumlah Progress</label>
                    <input type="text" name="rsb-jml_paket" class="form-control" id="rsb-jml_paket">
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="rsb-tgl_upd" class="form-control" id="rsb-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDataBidang()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editdatabidang" tabindex="-1" role="dialog" aria-labelledby="editdatabidangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editdatabidangLabel">Edit Data Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="bdg-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="batch">Batch</label>
                    <select data-plugin-selectTwo class="form-control" name="batch_id" id="bdg-batch_id">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bidang">Nama Bidang</label>
                    <select data-plugin-selectTwo class="form-control" name="bidang_id" id="bdg-bidang_id">
                       <?php foreach ($grafik as $gfk): ?>
                            <option value="<?= $gfk->bidang_id; ?>">
                                <?= $gfk->nama_bidang; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">Jumlah Paket</label>
                    <input type="text" name="jml_paket" class="form-control" id="bdg-jml_paket">
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="bdg-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateBidang()">Save changes</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>


</div>

<script>
    function editdatafisik(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("fsk-id").setAttribute('value', dataId);
        $('#editDataFisik').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailDataFisik',
            data: 'id=' + dataId,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Check the data in the console
                $.each(response, function(i, item) {
                    document.getElementById("fsk-batch_id").value = item.batch_id;
                    document.getElementById("fsk-fisik_progress_id").value = item.fisik_progress_id;
                    document.getElementById("fsk-jml_progress").value = item.jml_progress;
                    document.getElementById("fsk-tgl_upd").value = item.tgl_upd;
                });
            }
        });
        return false;
    }

    function editdatabidang(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("bdg-id").setAttribute('value', dataId);
        $('#editdatabidang').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailDataBidang',
            data: 'id=' + dataId,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Check the data in the console
                $.each(response, function(i, item) {
                    document.getElementById("bdg-bidang_id").value = item.bidang_id;
                    document.getElementById("bdg-batch_id").value = item.batch_id;
                    document.getElementById("bdg-jml_paket").value = item.jml_paket;
                    document.getElementById("bdg-tgl_upd").value = item.tgl_upd;
                });
            }
        });
        return false;
    }


    function calculateDeviasi() {
        const rencana = parseFloat(document.getElementById('rencana').value) || 0;
        const realisasi = parseFloat(document.getElementById('realisasi').value) || 0;
        const deviasi = realisasi - rencana;

        document.getElementById('deviasi').value = deviasi.toFixed(2); // Display the result as a decimal with 2 places
    }

    function calculateDeviasi2() {
        const rencana = parseFloat(document.getElementById('rsm-rencana').value) || 0;
        const realisasi = parseFloat(document.getElementById('rsm-realisasi').value) || 0;
        const deviasi = realisasi - rencana;

        document.getElementById('rsm-deviasi').value = deviasi.toFixed(2); // Display the result as a decimal with 2 places
    }

   function edit(elem) {
    var dataId = $(elem).data("id");
    $('#id').val(dataId);

    $('#editDataPelaksanaan').modal('show');

    $.ajax({
        type: 'GET',
        url: '<?= base_url() ?>detailPelaksanaan',
        data: { id: dataId },
        dataType: 'json',
        success: function(response) {
            $.each(response, function(i, item) {
                $('#batch_id').val(item.batch_id).trigger('change');
                $('#ket_1').val(item.ket_1);
                $('#ket_2').val(item.ket_2);
                $('#ket_3').val(item.ket_3);
                $('#jml_paket').val(item.jml_paket);
                $('#total_pagu').val(item.total_pagu);
                $('#progress_fisik').val(item.progress_fisik);

                const formattedDate = item.tgl_upd.split(' ')[0];
                $('#tgl_upd').val(formattedDate);
            });
        }
    });

    return false;
}



    function updateData() {
        var id = document.getElementById("id").value;
        var batch_id = $("#batch_id").val();
        var ket_1 = $("#ket_1").val();
        var ket_2 = $("#ket_2").val();
        var ket_3 = $("#ket_3").val();
        var jml_paket = $("#jml_paket").val();
        var total_pagu = $("#total_pagu").val();
        var progress_fisik = $("#progress_fisik").val();
        var tgl_upd = $("#tgl_upd").val();


        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updatePelaksanaan', // Adjust as needed for your update endpoint
            data: {
                id: id,
                batch_id: batch_id,
                ket_1: ket_1,
                ket_2: ket_2,
                ket_3: ket_3,
                jml_paket: jml_paket,
                total_pagu: total_pagu,
                progress_fisik: progress_fisik,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDataPelaksanaan').modal('hide');
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
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonText: 'OK'
                });
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }


    function updateBidang() {
        var id = document.getElementById("bdg-id").value;
        var batch_id = $("#bdg-batch_id").val();
        var bidang_id = $("#bdg-bidang_id").val();
        var jml_paket = $("#bdg-jml_paket").val();
        var tgl_upd = $("#bdg-tgl_upd").val();


        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateBidang', // Adjust as needed for your update endpoint
            data: {
                id: id,
                batch_id: batch_id,
                bidang_id: bidang_id,
                jml_paket: jml_paket,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editdatabidang').modal('hide');
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
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonText: 'OK'
                });
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }
</script>

<script>
    function saveData() {
        $.ajax({
            url: '<?= base_url(); ?>storePelaksanaan', // Replace with your actual endpoint
            method: 'POST',
            data: {
                batch_id: $('select[name="batch_id"]').val(),
                ket_1: $('input[name="ket_1"]').val(),
                ket_2: $('input[name="ket_2"]').val(),
                ket_3: $('input[name="ket_3"]').val(),
                jml_paket: $('input[name="jml_paket"]').val(),
                total_pagu: $('input[name="total_pagu"]').val(),
                progress_fisik: $('input[name="progress_fisik"]').val(),
                tgl_upd: $('input[name="tgl_upd"]').val()
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
                        $('#exampleModal').modal('hide');
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
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan dalam menyimpan data.',
                    confirmButtonText: 'OK'
                });
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }


function saveDataResume() {
        $.ajax({
            url: '<?= base_url(); ?>storeResumePelaksanaan', // Replace with your actual endpoint
            method: 'POST',
            data: {
                unor: $('input[name="trs-unor"]').val(),
                nama_paket: $('input[name="trs-nama_paket"]').val(),
                rencana: $('input[name="trs-rencana"]').val(),
                realisasi: $('input[name="trs-realisasi"]').val(),
                deviasi: $('input[name="trs-deviasi"]').val(),
                status: $('select[name="trs-status"]').val(),
                isu: $('textarea[name="trs-isu"]').val(),
                tgl_data: $('input[name="trs-tgl_data"]').val()
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
                        $('#resumePelaksanaan').modal('hide');
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

 let deleteId = null;

    function deleteResumePlk(id) {
        deleteId = id; // Set the ID of the worker to be deleted
    }

    function deleteDataResume() {
        if (deleteId) {
            // Proceed with AJAX request if confirmed
            $.ajax({
                url: '<?= base_url('deleteResumePelaksanaan'); ?>',
                type: 'POST',
                data: {
                    id: deleteId // Send the ID in the request body
                },
                success: function(result) {
                    // Handle success
                    $('#deleteResumePelaksanaan').modal('hide');
                    // Show success alert
                    Swal.fire(
                        'Deleted!',
                        'Berhasil menghapus data.',
                        'success'
                    );
                    location.reload(); // Reload the page to see changes
                },
                error: function(xhr, status, error) {
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Hapus data gagal',
                        text: error
                    });
                }
            });
        }
    }



    function saveDataFisik() {
        $.ajax({
            url: '<?= base_url(); ?>storeResumeFisik', // Replace with your actual endpoint
            method: 'POST',
            data: {
                batch_id: $('select[name="rsf-batch_id"]').val(),
                fisik_progress_id: $('select[name="rsf-fisik_progress_id"]').val(),
                jml_progress: $('input[name="rsf-jml_progress"]').val(),
                tgl_upd: $('input[name="rsf-tgl_upd"]').val(),
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
                        $('#exampleModal').modal('hide');
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

    function saveDataBidang() {
        $.ajax({
            url: '<?= base_url(); ?>storeResumeBidang', // Replace with your actual endpoint
            method: 'POST',
            data: {
                batch_id: $('select[name="rsb-batch_id"]').val(),
                bidang_id: $('select[name="rsb-bidang_id"]').val(),
                jml_paket: $('input[name="rsb-jml_paket"]').val(),
                tgl_upd: $('input[name="rsb-tgl_upd"]').val(),
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
                        $('#resumeBidang').modal('hide');
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Data for the first chart (data-grafik)
        const rawDataGrafik = <?= json_encode($grafik); ?>;

        // Process data for the first chart
        const labelsGrafik = [...new Set(rawDataGrafik.map(item => item.nama_batch))];
        const bidangNames = [...new Set(rawDataGrafik.map(item => item.nama_bidang))];
        const ctxX = document.getElementById('myBarChart').getContext('2d');
const datasetsGrafik = bidangNames.map(bidang => {
    const data = labelsGrafik.map(batch => {
        const entry = rawDataGrafik.find(
            item => item.nama_batch === batch && item.nama_bidang === bidang
        );
        return entry ? entry.jml_paket : 0;
    });

    return {
        label: bidang,
        data: data,
        backgroundColor: getGradient(ctxX, bidang),
        borderColor: '#1F2937',
        borderWidth: 0,
        barThickness: 40
    };
});


        // Chart configuration for myBarChart
        const configBarChart = {
            type: 'bar',
            data: {
                labels: labelsGrafik,
                datasets: datasetsGrafik,
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            display: false // Disable horizontal grid lines
                        },
                        ticks: {
                            font: {
                                family: 'Montserrat',
                                size: 14
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            font: {
                                family: 'Montserrat',
                                size: 14
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                family: 'Montserrat',
                                size: 12
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'middle',
                        align: 'middle',
                        formatter: (value) => value,
                        color: 'black',
                        font: {
                            family: 'Montserrat',
                            size: 12
                        },
                        offset: 2
                    }
                }
            },
            plugins: [ChartDataLabels]
        };

        // Create the first chart
        const myBarChart = new Chart(ctxX, configBarChart);
    });

    // Function to get color based on bidang for the first chart
    function getGradient(ctx, bidang) {
    const gradient = ctx.createLinearGradient(0, 0, 400, 0); // horizontal (karena indexAxis: 'y')

    switch (bidang) {
        case 'Divisi Jalan':
            gradient.addColorStop(0, '#93C5FD'); // blue-300
            gradient.addColorStop(0.8, '#4173ff'); // blue-900
            break;

        case 'Divisi Penataan Kawasan':
            gradient.addColorStop(0, '#FCA5A5'); // red-300
            gradient.addColorStop(0.8, '#ff4343'); // red-900
            break;

        case 'Divisi Gedung dan Hunian':
            gradient.addColorStop(0, '#FDE68A'); // yellow-300
            gradient.addColorStop(0.8, '#ff751f'); // amber-800
            break;

        case 'Divisi Sumber Daya Air':
            gradient.addColorStop(0, '#D1FAE5'); // emerald-200
            gradient.addColorStop(0.8, '#17ff55'); // emerald-900
            break;

        case 'Divisi Jaringan Utilitas':
            gradient.addColorStop(0, '#ff6745'); // emerald-200
            gradient.addColorStop(0.8, '#17ff55'); // emerald-900
            break;

        default:
            gradient.addColorStop(0, '#DDD6FE'); // violet-200
            gradient.addColorStop(0.8, '#8a3cff'); // violet-900
    }

    return gradient;
}


</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Data for the second chart (data-fisik)
        const rawDataFisik = <?= json_encode($fisik); ?>;

        // Process data for the second chart
        const labelsFisik = [...new Set(rawDataFisik.map(item => item.nama_progress_fisik))];
        const batchNamesFisik = [...new Set(rawDataFisik.map(item => item.nama_batch))];

        const datasetsFisik = batchNamesFisik.map(batch => {
            const data = labelsFisik.map(progress_fisik => {
                const entry = rawDataFisik.find(item => item.nama_progress_fisik === progress_fisik && item.nama_batch === batch);
                return entry ? entry.jml_progress : 0; // If not found, set to 0
            });

            return {
                label: batch,
                data: data,
                backgroundColor: getColorFisik(batch), // Get color based on batch
            };
        });

        // Chart configuration for myChart
        const ctxY = document.getElementById('myChart').getContext('2d');
        const configY = {
            type: 'bar',
            data: {
                labels: labelsFisik,
                datasets: datasetsFisik,
            },
            options: {
                indexAxis: 'x',
                scales: {
                    x: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Montserrat',
                                size: 14
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: false // Disable horizontal grid lines
                        },
                        ticks: {
                            font: {
                                family: 'Montserrat',
                                size: 14
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                family: 'Montserrat',
                                size: 12
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'middle',
                        align: 'middle',
                        formatter: (value) => value,
                        color: 'black',
                        font: {
                            family: 'Montserrat',
                            size: 12
                        },
                        offset: 2
                    }
                }
            },
            plugins: [ChartDataLabels]
        };

        // Create the second chart
        const myChart = new Chart(ctxY, configY);
    });

    // Function to get color based on batch for the second chart
    function getColorFisik(batch) {
        switch (batch) {
            case 'Batch 1':
                return 'rgba(54, 162, 235, 1)';
            case 'Batch 2':
                return 'rgba(255, 206, 86, 1)';
            case 'Batch 3':
                return 'rgba(255, 99, 132, 1)';
            default:
                return 'rgba(153, 102, 255, 1)';
        }
    }


    function editDataResume(button) {
        // Dapatkan ID dari atribut data-id pada tombol yang diklik
        var id = $(button).data('id');

        // Setel ID ke input tersembunyi di modal
        $('#rsm-id').val(id);

        // Lakukan AJAX atau lainnya untuk mendapatkan detail pekerja berdasarkan ID
        $.ajax({
            url: '<?= base_url("detailResumePelaksanaan"); ?>/' + id, // Endpoint untuk mengambil data pekerja berdasarkan ID
            method: 'GET',
            success: function(data) {
                // Isi data modal dengan nilai yang diterima dari respons
                $('#rsm-unor').val(data.unor);
                $('#rsm-nama_paket').val(data.nama_paket);
                $('#rsm-rencana').val(data.rencana);
                $('#rsm-realisasi').val(data.realisasi);
                $('#rsm-deviasi').val(data.deviasi);
                $('#rsm-status').val(data.status);
                $('#rsm-isu').val(data.isu);
                $('#rsm-tgl_data').val(data.tgl_data);
            },
            error: function(err) {
                console.log('Error:', err);
            }
        });
    }

    function updateResume() {
        let id = $('#rsm-id').val();
        let unor = $('#rsm-unor').val();
        let nama_paket = $('#rsm-nama_paket').val();
        let rencana = $('#rsm-rencana').val();
        let realisasi = $('#rsm-realisasi').val();
        let deviasi = $('#rsm-deviasi').val();
        let status = $('#rsm-status').val();
        let isu = $('#rsm-isu').val();
        let tgl_data = $('#rsm-tgl_data').val();

        $.post('<?= base_url('updateResumePelaksanaan'); ?>', {
            id: id, // Ensure 'id' is sent
            unor: unor,
            nama_paket: nama_paket,
            rencana: rencana,
            realisasi: realisasi,
            deviasi: deviasi,
            status: status,
            isu: isu,
            tgl_data: tgl_data
        }, function(response) {
            let result = JSON.parse(response);
            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                    confirmButtonText: 'OK'
                });
            }

        });
    }

    function updateFisik() {
        var id = document.getElementById("fsk-id").value;
        var batch_id = $("#fsk-batch_id").val();
        var fisik_progress_id = $("#fsk-fisik_progress_id").val();
        var jml_progress = $("#fsk-jml_progress").val();
        var tgl_upd = $("#fsk-tgl_upd").val();

        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateDataFisik', // Adjust as needed for your update endpoint
            data: {
                id: id,
                batch_id: batch_id,
                fisik_progress_id: fisik_progress_id,
                jml_progress: jml_progress,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDataFisik').modal('hide');
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
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
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
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $(document).ready(function() {
        $('#myTable2').DataTable();
    });
    $(document).ready(function() {
        $('#myTable3').DataTable();
    });
</script>



<?= $this->endSection() ?>
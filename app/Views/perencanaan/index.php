<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Content Row -->

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Tombol Update Data Pelaksanaan di sebelah kiri -->
    <?php if (user()->username == 'admin') : ?>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
            Update Data Perencanaan <i class="fa fa-plus"></i>
        </button>
    <?php endif; ?>

    <!-- Input filter dan tombol filter di sebelah kanan -->
    <div class="d-flex align-items-center">
        <form method="get" action="<?= base_url('progress/perencanaan'); ?>" class="d-flex justify-content-end">
            <select name="tgl_upd" id="tgl_upd" class="form-control me-2">
                <option value="00">Pilih tanggal</option>
                <?php foreach ($option_waktu as $data): ?>
                    <option value="<?php echo $data->tgl_upd; ?>"><?php echo $data->tgl_upd; ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary ml-2">Filter</button>
            <a href="<?= base_url('progress/perencanaan'); ?>" class="btn btn-warning ml-2">Reset</a>
        </form>
    </div>
</div>
<?php foreach ($tgl_upd as $tgl): ?>
    <p class="text-left text-muted mb-2">
        Data upd :
        <?= date('F d, Y', strtotime($tgl)); ?>
    </p>
<?php endforeach; ?>
<div class="row">

<?php foreach ($total as $ttl): ?>
<div class="col-xl-12 mb-4">
	<div class="card card-dashboard h-100">
		<div class="card-body">

			<div class="d-flex justify-content-between align-items-center mb-3">
				<div>
					<h6 class="mb-0 font-weight-bold text-uppercase">
						<?= $ttl->nama_batch ?>
					</h6>
					<small class="text-muted"><?= $ttl->ket_1 ?></small>
				</div>

				<?php if (user()->username == 'admin') : ?>
					<button class="btn btn-sm btn-outline-warning"
						data-toggle="modal"
						data-target="#editDataPerencanaan"
						onclick="edit(this)"
						data-id="<?= esc($ttl->id); ?>">
						<i class="fi fi-tr-file-edit"></i>
					</button>
				<?php endif; ?>
			</div>

			<div class="row text-center">
				<div class="col-md-6">
					<div class="text-muted small">Jumlah Paket</div>
					<div class="display-4 font-weight-bold gradient-text">
						<?= $ttl->jml_paket ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="text-muted small">Progress Perencanaan</div>
					<div class="display-4 font-weight-bold text-success">
						<?= $ttl->progress_perencanaan ?>%
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php endforeach; ?>

<?php foreach ($perencanaan as $prc): ?>
<div class="col-xl-4 col-md-6 mb-4">
	<div class="card card-dashboard h-100">
		<div class="card-body">

			<div class="d-flex justify-content-between align-items-center mb-3">
				<div>
					<h6 class="mb-0 font-weight-bold text-uppercase">
						<?= $prc->nama_batch ?>
					</h6>
					<small class="text-muted"><?= $prc->ket_1 ?></small>
				</div>

				<?php if (user()->username == 'admin') : ?>
					<button class="btn btn-sm btn-outline-warning"
						data-toggle="modal"
						data-target="#editDataPerencanaan"
						onclick="edit(this)"
						data-id="<?= esc($prc->id); ?>">
						<i class="fi fi-tr-file-edit"></i>
					</button>
				<?php endif; ?>
			</div>

			<div class="text-center mb-3">
				<div class="text-muted small">Jumlah Paket</div>
				<div class="display-4 font-weight-bold gradient-text">
					<?= $prc->jml_paket ?>
				</div>
			</div>

			<hr>

			<div class="text-center">
				<div class="text-muted small">Progress</div>
				<div class="font-weight-bold h4 text-success">
					<?= $prc->progress_perencanaan ?>%
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
        <div class="card shadow mb-4 overflow-hidden overflow-x-auto">
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="renrelChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4 overflow-hidden overflow-x-auto">
            <!-- Card Header - Dropdown -->
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
    <div class="card shadow-sm mb-4">
        <!-- CARD HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="mb-0 font-weight-bold">Edit Chart</h6>

            <div class="dropdown">
                <button class="btn btn-outline-warning btn-sm dropdown-toggle" type="button"
                    id="dropdownCreateButton" data-toggle="dropdown">
                    <i class="fi fi-tr-plus mr-1"></i> Create Data
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createRenrelModal">
                        Rencana & Realisasi
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createOnselModal">
                        Ongoing & Selesai
                    </a>
                </div>
            </div>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <div class="row">

                <!-- ================= TABLE RENREL ================= -->
                <div class="col-md-6 mb-4">
                    <h6 class="font-weight-bold text-dark mb-3">
                        Rencana & Realisasi
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Batch</th>
                                    <th>Ren</th>
                                    <th>Rel</th>
                                    <th>Tgl Upd</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($dataPerencanaan as $dtp): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $dtp->nama_batch; ?></td>
                                        <td class="text-center"><?= $dtp->rencana; ?></td>
                                        <td class="text-center"><?= $dtp->realisasi; ?></td>
                                        <td class="text-center"><?= date('d M Y', strtotime($dtp->tgl_upd)); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-warning"
                                                    onclick="editDtp1(this)"
                                                    data-id="<?= $dtp->id; ?>"
                                                    data-nama="<?= $dtp->batch_id; ?>"
                                                    data-rencana="<?= $dtp->rencana; ?>"
                                                    data-realisasi="<?= $dtp->realisasi; ?>"
                                                    data-tgl_upd="<?= $dtp->tgl_upd; ?>">
                                                    <i class="fi fi-tr-file-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger"
                                                    onclick="deleteDtp1(this)"
                                                    data-id="<?= $dtp->id; ?>">
                                                    <i class="fi fi-tr-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ================= TABLE ONSEL ================= -->
                <div class="col-md-6 mb-4">
                    <h6 class="font-weight-bold text-dark mb-3">
                        Ongoing & Selesai
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Batch</th>
                                    <th>Ongoing</th>
                                    <th>Selesai</th>
                                    <th>Tgl Upd</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($dataOnsel as $dtp): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $dtp->nama_batch; ?></td>
                                        <td class="text-center"><?= $dtp->ren_ongoing; ?></td>
                                        <td class="text-center"><?= $dtp->ren_sel; ?></td>
                                        <td class="text-center"><?= date('d M Y', strtotime($dtp->tgl_upd)); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-warning"
                                                    onclick="editOnsel(this)"
                                                    data-id="<?= $dtp->id; ?>"
                                                    data-nama="<?= $dtp->batch_id; ?>"
                                                    data-ongoing="<?= $dtp->ren_ongoing; ?>"
                                                    data-sel="<?= $dtp->ren_sel; ?>">
                                                    <i class="fi fi-tr-file-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger"
                                                    onclick="deleteOnsel(this)"
                                                    data-id="<?= $dtp->id; ?>">
                                                    <i class="fi fi-tr-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Update Data Perencanaan</h5>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Jumlah Paket</label>
                                <input type="text" name="jml_paket" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Progress Perencanaan</label>
                                <input type="text" name="progress_perencanaan" class="form-control" id="exampleFormControlInput1">
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
    <div class="modal fade" id="editDataPerencanaan" tabindex="-1" role="dialog" aria-labelledby="editDataPerencanaanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editDataPerencanaanLabel">Edit Data Perencanaan</h5>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jml_paket">Jumlah Paket</label>
                                <input type="text" name="jml_paket" class="form-control" id="jml_paket">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="progress_perencanaan">Total Pagu</label>
                                <input type="text" name="progress_perencanaan" class="form-control" id="progress_perencanaan">
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

</div>


<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModalLabel">Create New Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="createNamaBatch">Batch</label>
                        <select data-plugin-selectTwo class="form-control" id="createNamaBatch">
                            <?php foreach ($batch as $btc): ?>
                                <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createRencana" class="form-label">Rencana</label>
                        <input type="text" class="form-control" id="createRencana">
                    </div>
                    <div class="mb-3">
                        <label for="createRealisasi" class="form-label">Realisasi</label>
                        <input type="text" class="form-control" id="createRealisasi">
                    </div>
                    <div class="mb-3">
                        <label for="createTglUpd" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="createTglUpd">
                    </div>
                    <button type="button" class="btn btn-primary float-right" onclick="saveCreate()">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="batch_id">Batch</label>
                        <select data-plugin-selectTwo class="form-control" id="editNamaBatch">
                            <?php foreach ($batch as $btc): ?>
                                <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editRencana" class="form-label">Rencana</label>
                        <input type="text" class="form-control" id="editRencana">
                    </div>
                    <div class="mb-3">
                        <label for="editRealisasi" class="form-label">Realisasi</label>
                        <input type="text" class="form-control" id="editRealisasi">
                    </div>
                    <div class="mb-3">
                        <label for="editTglUpd" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="editTglUpd">
                    </div>
                    <button type="button" class="btn btn-success float-right" onclick="saveEdit()">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editOnselModal" tabindex="-1" aria-labelledby="editOnselModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editOnselModalLabel">Edit Data Onsel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editOnselForm">
                    <input type="hidden" id="editOnselId">
                    <select data-plugin-selectTwo class="form-control" id="editOnselNamaBatch">
                        <?php foreach ($batch as $btc): ?>
                            <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mb-3">
                        <label for="editOnselOngoing" class="form-label">Rencana On going</label>
                        <input type="text" class="form-control" id="editOnselOngoing">
                    </div>
                    <div class="mb-3">
                        <label for="editOnselSel" class="form-label">Selesai</label>
                        <input type="text" class="form-control" id="editOnselSel">
                    </div>
                    <div class="mb-3">
                        <label for="editTglUpdOnsel" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="editTglUpdOnsel">
                    </div>
                    <button type="button" class="btn btn-success float-right" onclick="saveEditOnsel()">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteOnselModal" tabindex="-1" aria-labelledby="deleteOnselModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteOnselModalLabel">Hapus Data On going dan Selesai</h5>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <input type="hidden" id="deleteOnselId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Renrel Modal -->
<div class="modal fade" id="createRenrelModal" tabindex="-1" aria-labelledby="createRenrelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createRenrelModalLabel">Create Renrel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createRenrelForm">
                    <div class="mb-3">
                        <label for="renrelBatch">Batch</label>
                        <select data-plugin-selectTwo class="form-control" id="renrelBatch">
                            <?php foreach ($batch as $btc): ?>
                                <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="renrelRencana" class="form-label">Rencana</label>
                        <input type="text" class="form-control" id="renrelRencana">
                    </div>
                    <div class="mb-3">
                        <label for="renrelRealisasi" class="form-label">Realisasi</label>
                        <input type="text" class="form-control" id="renrelRealisasi">
                    </div>
                    <div class="mb-3">
                        <label for="renrelTglUpd" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="renrelTglUpd">
                    </div>
                    <button type="button" class="btn btn-primary float-right" onclick="saveRenrel()">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Create Onsel Modal -->
<div class="modal fade" id="createOnselModal" tabindex="-1" aria-labelledby="createOnselModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createOnselModalLabel">Create On going dan Selesai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createOnselForm">
                    <div class="mb-3">
                        <label for="onselBatch">Batch</label>
                        <select data-plugin-selectTwo class="form-control" id="onselBatch">
                            <?php foreach ($batch as $btc): ?>
                                <option value="<?= $btc->id_batch; ?>"><?= $btc->nama_batch; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="onselOnGoing" class="form-label">Rencana Ongoing</label>
                        <input type="text" class="form-control" id="onselOngoing">
                    </div>
                    <div class="mb-3">
                        <label for="onselSelesai" class="form-label">Selesai </label>
                        <input type="text" class="form-control" id="onselSelesai">
                    </div>
                    <div class="mb-3">
                        <label for="onselTglUpd" class="form-label">Tanggal Update</label>
                        <input type="date" class="form-control" id="onselTglUpd">
                    </div>
                    <button type="button" class="btn btn-success float-right" onclick="saveOnsel()">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>


</div>



<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
<script>
    // Data dari server melalui PHP untuk rencana-realisasi
    const dataPerencanaan = <?= json_encode($dataPerencanaan) ?>;
    const dataOnsel = <?= json_encode($dataOnsel) ?>;

    // Siapkan data untuk chart Rencana vs Realisasi
    const renrelLabels = dataPerencanaan.map(item => item.nama_batch);
    const rencanaData = dataPerencanaan.map(item => item.rencana);
    const realisasiData = dataPerencanaan.map(item => item.realisasi);

    // Buat chart untuk Rencana vs Realisasi
    const renrelCtx = document.getElementById('renrelChart').getContext('2d');
    // Gradient untuk Rencana (biru–ungu gelap)
    const gradientRencana = renrelCtx.createLinearGradient(0, 0, 0, 300);
    gradientRencana.addColorStop(0, '#5C6BC0'); // soft indigo
    gradientRencana.addColorStop(1, '#283593'); // deep navy

    // Gradient untuk Realisasi (merah gelap)
    const gradientRealisasi = renrelCtx.createLinearGradient(0, 0, 0, 300);
    gradientRealisasi.addColorStop(0, '#FF7043'); // soft orange red
    gradientRealisasi.addColorStop(1, '#BF360C'); // dark red

    const renrelChart = new Chart(renrelCtx, {
        type: 'bar',
        data: {
            labels: renrelLabels,
            datasets: [{
                    label: 'Rencana',
                    data: rencanaData,
                    backgroundColor: gradientRencana,
                    borderColor: 'rgba(165, 180, 252, 1)',
                    borderWidth: 0
                },
                {
                    label: 'Realisasi',
                    data: realisasiData,
                    backgroundColor: gradientRealisasi,
                    borderColor: 'rgba(252, 165, 165, 1)',
                    borderWidth: 0
                }
            ]
        },
        options: {
            indexAxis: 'x',
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 14
                        }
                    }
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            family: 'Poppins',
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
                        family: 'Poppins',
                        size: 12
                    },
                    offset: 2
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Siapkan data untuk chart OnGoing vs Selesai
    const onselLabels = dataOnsel.map(item => item.nama_batch);
    const renOngoingData = dataOnsel.map(item => item.ren_ongoing);
    const renSelesaiData = dataOnsel.map(item => item.ren_sel);

    // Buat chart untuk OnGoing vs Selesai
    const onselCtx = document.getElementById('myChart').getContext('2d');
    const gradientOngoing = onselCtx.createLinearGradient(0, 0, 0, 300);
    gradientOngoing.addColorStop(0, '#90CAF9'); // biru muda
    gradientOngoing.addColorStop(1, '#1E3A8A'); // navy

    const gradientSelesai = onselCtx.createLinearGradient(0, 0, 0, 300);
    gradientSelesai.addColorStop(0, '#66BB6A'); // hijau soft
    gradientSelesai.addColorStop(1, '#1B5E20'); // hijau gelap
    const onselChart = new Chart(onselCtx, {
        type: 'bar',
        data: {
            labels: onselLabels,
            datasets: [{
                    label: 'Perencanaan Ongoing',
                    data: renOngoingData,
                    backgroundColor: gradientOngoing,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 0
                },
                {
                    label: 'Perencanaan Selesai',
                    data: renSelesaiData,
                    backgroundColor: gradientSelesai,
                    borderColor: 'rgb(6, 125, 52)',
                    borderWidth: 0
                }
            ]
        },
        options: {
            indexAxis: 'x',
            scales: {
                x: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 14
                        }
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 14
                        }
                    }
                },
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            family: 'Poppins',
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
                        family: 'Poppins',
                        size: 12
                    },
                    offset: 2
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

<script>
    function saveData() {
        $.ajax({
            url: '<?= base_url(); ?>storePerencanaan', // Replace with your actual endpoint
            method: 'POST',
            data: {
                batch_id: $('select[name="batch_id"]').val(),
                ket_1: $('input[name="ket_1"]').val(),
                ket_2: $('input[name="ket_2"]').val(),
                jml_paket: $('input[name="jml_paket"]').val(),
                progress_perencanaan: $('input[name="progress_perencanaan"]').val(),
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
</script>
<script>
    function edit(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("id").setAttribute('value', dataId);
        $('#editDataPerencanaan').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailPerencanaan',
            data: 'id=' + dataId,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Log the response to check the data structure
                $.each(response, function(i, item) {
                    document.getElementById("ket_1").setAttribute('value', item.ket_1);
                    document.getElementById("ket_2").setAttribute('value', item.ket_2);
                    document.getElementById("jml_paket").setAttribute('value', item.jml_paket);
                    document.getElementById("progress_perencanaan").setAttribute('value', item.progress_perencanaan);
                    document.getElementById("tgl_upd").setAttribute('value', item.tgl_upd);
                    // Set the value of the Select2 element for batch_id
                    $("#batch_id").val(item.batch_id).trigger('change');
                    const formattedDate = new Date(item.tgl_upd).toISOString().split('T')[0];
                    document.getElementById("tgl_upd").value = formattedDate;
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
        var jml_paket = $("#jml_paket").val();
        var progress_perencanaan = $("#progress_perencanaan").val();
        var tgl_upd = $("#tgl_upd").val();


        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updatePerencanaan', // Adjust as needed for your update endpoint
            data: {
                id: id,
                batch_id: batch_id,
                ket_1: ket_1,
                ket_2: ket_2,
                jml_paket: jml_paket,
                progress_perencanaan: progress_perencanaan,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDataPerencanaan').modal('hide');
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
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }



    function editDtp1(button) {
        // Ambil data dari atribut tombol
        var id = button.getAttribute("data-id");
        var nama = button.getAttribute("data-nama");
        var rencana = button.getAttribute("data-rencana");
        var realisasi = button.getAttribute("data-realisasi");
        var tgl_upd = button.getAttribute("data-tgl_upd");

        // Set nilai dalam input dan select
        $("#editId").val(id);
        $("#editNamaBatch").val(nama).trigger('change'); // Trigger change jika menggunakan Select2
        $("#editRencana").val(rencana);
        $("#editRealisasi").val(realisasi);
        $("#editTglUpd").val(tgl_upd);

        // Tampilkan modal
        $('#editModal').modal('show');
    }


    function saveCreate() {
        const batch_id = $("#createNamaBatch").val();
        const rencana = $("#createRencana").val();
        const realisasi = $("#createRealisasi").val();
        const tgl_upd = $("#createTglUpd").val();

        // Validasi data jika diperlukan
        if (!batch_id || !rencana || !realisasi || !tgl_upd) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Semua field wajib diisi.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // AJAX request to create data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>createPerencanaan', // Ganti dengan URL endpoint Anda
            data: {
                batch_id: batch_id,
                rencana: rencana,
                realisasi: realisasi,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Tutup modal
                    $('#createModal').modal('hide');
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                    // Refresh halaman setelah beberapa detik
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

    function saveRenrel() {
        const batch_id = $("#renrelBatch").val();
        const rencana = $("#renrelRencana").val();
        const realisasi = $("#renrelRealisasi").val();
        const tgl_upd = $("#renrelTglUpd").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>storeRenrel', // Ganti dengan endpoint Renrel
            data: {
                batch_id,
                rencana,
                realisasi,
                tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#createRenrelModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            }
        });
    }



    function saveEdit() {
        // Ambil nilai dari input dan select
        var id = $("#editId").val();
        var batch_id = $("#editNamaBatch").val();
        var rencana = $("#editRencana").val();
        var realisasi = $("#editRealisasi").val();
        var tgl_upd = $("#editTglUpd").val();

        // AJAX request untuk menyimpan data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateRenrelChart', // Sesuaikan dengan endpoint update
            data: {
                id: id,
                batch_id: batch_id,
                rencana: rencana,
                realisasi: realisasi,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Tutup modal
                    $('#editModal').modal('hide');
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                    // Refresh halaman setelah 2 detik
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    // Tampilkan notifikasi gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                // Tampilkan notifikasi error
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonText: 'OK'
                });
                // Reload halaman untuk memastikan data terbaru
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }


    function updateData() {
        var id = document.getElementById("id").value;
        var batch_id = $("#batch_id").val();
        var ket_1 = $("#ket_1").val();
        var ket_2 = $("#ket_2").val();
        var jml_paket = $("#jml_paket").val();
        var progress_perencanaan = $("#progress_perencanaan").val();
        var tgl_upd = $("#tgl_upd").val();


        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updatePerencanaan', // Adjust as needed for your update endpoint
            data: {
                id: id,
                batch_id: batch_id,
                ket_1: ket_1,
                ket_2: ket_2,
                jml_paket: jml_paket,
                progress_perencanaan: progress_perencanaan,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDataPerencanaan').modal('hide');
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
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }




    function deleteDtp1(button) {
        const id = button.getAttribute("data-id");

        // Set ID in the modal
        document.getElementById("deleteId").value = id;

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
        deleteModal.show();
    }


    function confirmDelete() {
        const id = document.getElementById("deleteId").value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>deleteRenOnsel',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    Swal.fire('Deleted!', response.message, 'success');
                    location.reload(); // Refresh the page or update the table dynamically
                } else {
                    Swal.fire('Failed!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
            }
        });
    }



    function saveOnsel() {
        const batch_id = $("#onselBatch").val();
        const ren_ongoing = $("#onselOngoing").val();
        const ren_sel = $("#onselSelesai").val();
        const tgl_upd = $("#onselTglUpd").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>storeOnsel', // Ganti dengan endpoint Onsel
            data: {
                batch_id,
                ren_ongoing,
                ren_sel,
                tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#createOnselModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            }
        });
    }


    function editOnsel(button) {
        const id = button.getAttribute("data-id");
        const nama = button.getAttribute("data-nama");
        const ongoing = button.getAttribute("data-ongoing");
        const sel = button.getAttribute("data-sel");

        // Set values in the modal
        document.getElementById("editOnselId").value = id;
        document.getElementById("editOnselNamaBatch").value = nama;
        document.getElementById("editOnselOngoing").value = ongoing;
        document.getElementById("editOnselSel").value = sel;

        // Show the modal
        const editModal = new bootstrap.Modal(document.getElementById("editOnselModal"));
        editModal.show();
    }

    function saveEditOnsel() {
        // Ambil nilai dari input dan select
        var id = $("#editOnselId").val();
        var batch_id = $("#editOnselNamaBatch").val();
        var ren_ongoing = $("#editOnselOngoing").val();
        var ren_sel = $("#editOnselSel").val();
        var tgl_upd = $("#editTglUpdOnsel").val();

        // AJAX request untuk menyimpan data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateOnselChart', // Sesuaikan dengan endpoint update
            data: {
                id: id,
                batch_id: batch_id,
                ren_ongoing: ren_ongoing,
                ren_sel: ren_sel,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Tutup modal
                    $('#editModal').modal('hide');
                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                    // Refresh halaman setelah 2 detik
                    window.setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    // Tampilkan notifikasi gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                // Tampilkan notifikasi error
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    confirmButtonText: 'OK'
                });
                // Reload halaman untuk memastikan data terbaru
                window.setTimeout(function() {
                    location.reload();
                }, 2000);
            }
        });
    }


    function deleteOnsel(button) {
        const id = button.getAttribute("data-id");

        // Set ID in the modal
        document.getElementById("deleteOnselId").value = id;

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteOnselModal"));
        deleteModal.show();
    }

    function confirmDeleteOnsel() {
        const id = document.getElementById("deleteId").value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>deleteRenOnsel',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteModal').modal('hide');
                    Swal.fire('Deleted!', response.message, 'success');
                    location.reload(); // Refresh the page or update the table dynamically
                } else {
                    Swal.fire('Failed!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
            }
        });
    }
</script>


<?= $this->endSection() ?>
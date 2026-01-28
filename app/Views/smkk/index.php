<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>


<?php foreach ($last_upd_data as $tgl_upd): ?>
    <p>Status Data : <?= date('F', strtotime($tgl_upd->tgl_upd)); // Convert to month name 
                        ?> <?= date('d, Y', strtotime($tgl_upd->tgl_upd)); // Display day and year 
                            ?></p>
<?php endforeach; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
        <form method="get" action="<?= base_url('resume/smkk'); ?>" class="d-flex justify-content-end">
            <select name="tgl_upd" id="tgl_upd" class="form-control me-2">
                <option value="00">Pilih tanggal</option>
                <?php foreach ($option_waktu as $data): ?>
                    <option value="<?= $data->tgl_upd; ?>"><?= $data->tgl_upd; ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary ml-2">Filter</button>
            <a href="<?= base_url('resume/smkk'); ?>" type="button" class="btn btn-warning ml-2">Reset</a>
        </form>

    </div>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h6 class="h6 font-semibold mb-0 text-dark">Total Paket Pekerjaan on going 70 Paket</h6>
</div>

<div class="row">
    <div class="col-xl-12">
        <?php if (user()->username == 'admin') : ?>
            <button class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#tambahSMKK">
                Tambah Dokumen SMKK <i class="fa fa-plus"></i>
            </button>
        <?php endif; ?>

        <?php if (user()->username == 'admin') : ?>
            <button class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#storeSMKKDashboard">
                Tambah Dashboard SMKK <i class="fa fa-plus"></i>
            </button>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-sm-flex flex-row-reverse justify-content-between mb-4">
                            <h6 class="h6 font-semibold mb-0 head-badge-top-third text-white">Dokumen SMKK</h6>
                            <?php foreach ($dokumen as $dkm) { ?>
                                <button class="btn btn-sm btn-outline-warning float-right"
                                    data-toggle="modal"
                                    data-target="#editDokumen"
                                    onclick="editdokumen(this)"
                                    data-id="<?= esc($dkm->id); ?>">
                                 <i class="fi fi-tr-file-edit"></i>
                                </button>
                        </div>
                        <div class="d-flex flex-row justify-content-between flex-wrap">
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-success text-center text-white">
                                    <p class="text-bold text-white">TERTIB</p>
                                    <h5 class="font-weight-bold"><?= $dkm->tertib; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-danger text-center text-white">
                                    <p class="text-bold text-white">TIDAK TERTIB</p>
                                    <h5 class="font-weight-bold"><?= $dkm->tidak_tertib; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-secondary text-center text-white">
                                    <p class="text-bold text-white">Jumlah Kecelakaan</p>
                                    <h5 class="font-weight-bold"><?= $dkm->jml_kecelakaan; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-success text-center text-white">
                                    <p class="text-bold text-white">Total Jam Kerja</p>
                                    <h5 class="font-weight-bold"><?= $dkm->total_jam_kerja; ?></h6>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <small class="text-muted font-italic"><?= $dkm->note; ?></small>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <div class="d-sm-flex flex-row-reverse justify-content-between mb-4">
                            <h6 class="h6 font-semibold mb-0 head-badge-top-third text-white">Dashboard SMKK</h6>
                            <?php foreach ($dashboard as $dsh) { ?>
                                <button class="btn btn-sm btn-outline-warning float-right"
                                    data-toggle="modal"
                                    data-target="#boardboard"
                                    onclick="boardboard(this)"
                                    data-id="<?= esc($dkm->id); ?>">
                                    <i class="fi fi-tr-file-edit"></i>
                                </button>
                        </div>
                        <div class="d-flex flex-row justify-content-between flex-wrap">
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-success text-center text-white">
                                    <p class="text-bold text-white">Memuaskan</p>
                                    <h5 class="font-weight-bold"><?= $dsh->memuaskan; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-primary text-center text-white">
                                    <p class="text-bold text-white">Baik</p>
                                    <h5 class="font-weight-bold"><?= $dsh->baik; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-warning text-center text-white">
                                    <p class="text-bold text-white">Cukup</p>
                                    <h5 class="font-weight-bold"><?= $dsh->cukup; ?></h5>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-danger text-center text-white">
                                    <p class="text-bold text-white">Kurang</p>
                                    <h5 class="font-weight-bold"><?= $dsh->kurang; ?></h6>
                                </div>
                            </div>
                            <div class="card flex-fill m-2">
                                <div class="card-body bg-success text-center text-white">
                                    <p class="text-bold text-white">Rata-rata Nilai Penerapan SMKK*</p>
                                    <h5 class="font-weight-bold"><?= $dsh->rata_nilai; ?></h6>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <small class="text-muted font-italic"><?= $dsh->note; ?></small>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <hr>
                <?php foreach ($catatan as $ctt) { ?>
                    <small class="text-muted">Catatan : <?= $ctt->note; ?></small>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDokumen" tabindex="-1" role="dialog" aria-labelledby="editDokumenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDokumenLabel">Edit Dokumen SMKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="smkk_jenis_id">Jenis SMKK</label>
                    <select data-plugin-selectTwo class="form-control" id="edit-smkk_jenis_id">
                        <?php foreach ($jenis_smkk as $jmk): ?>
                            <option value="<?= $jmk->id; ?>"><?= $jmk->nama_smkk; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tertib">Tertib</label>
                    <input type="text" name="tertib" class="form-control" id="edit-tertib">
                </div>
                <div class="form-group">
                    <label for="tidak_tertib">Tidak Tertib</label>
                    <input type="text" name="tidak_tertib" class="form-control" id="edit-tidak_tertib">
                </div>
                <div class="form-group">
                    <label for="jml_kecelakaan">Jumlah Kecelakaan</label>
                    <input type="text" name="jml_kecelakaan" class="form-control" id="edit-jml_kecelakaan">
                </div>
                <div class="form-group">
                    <label for="total_jam_kerja">Total Jam Kerja</label>
                    <input type="text" name="total_jam_kerja" class="form-control" id="edit-total_jam_kerja">
                </div>
                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea type="text" name="note" class="form-control" id="edit-note"></textarea>
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="edit-tgl_upd">
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
<div class="modal fade" id="tambahSMKK" tabindex="-1" role="dialog" aria-labelledby="tambahSMKKLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahSMKKLabel">Tambah Resume Dokumen SMKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSMKK" action="<?= base_url('storeSMKKDokumen'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="smkk_jenis_id">Jenis SMKK</label>
                        <select class="form-control" name="smkk_jenis_id" id="smkk_jenis_id">
                            <option value="1">Dokumen SMKK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tertib">Tertib</label>
                        <input type="text" name="tertib" class="form-control" id="tertib">
                    </div>
                    <div class="form-group">
                        <label for="tidak_tertib">Tidak Tertib</label>
                        <input type="text" name="tidak_tertib" class="form-control" id="tidak_tertib">
                    </div>
                    <div class="form-group">
                        <label for="jml_kecelakaan">Jumlah Kecelakaan</label>
                        <input type="text" name="jml_kecelakaan" class="form-control" id="jml_kecelakaan">
                    </div>
                    <div class="form-group">
                        <label for="total_jam_kerja">Total Jam Kerja</label>
                        <input type="text" name="total_jam_kerja" class="form-control" id="total_jam_kerja">
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" class="form-control" id="note"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tgl_upd">Tanggal Update</label>
                        <input type="date" name="tgl_upd" class="form-control" id="tgl_upd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="storeSMKKDashboard" tabindex="-1" role="dialog" aria-labelledby="tambahSMKKLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahSMKKLabel">Tambah Resume Dokumen SMKK</h5>
                <button type="button" class="close" data-dismiss="modal" Dashboard-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSMKKDashboard" action="<?= base_url('storeSMKKDashboard'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="smkk_jenis_id">Jenis SMKK</label>
                        <select class="form-control" name="smkk_jenis_id" id="str-smkk_jenis_id">
                            <option value="1">Dashboard SMKK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="memuaskan">Memuaskan</label>
                        <input type="text" name="memuaskan" class="form-control" id="str-memuaskan">
                    </div>
                    <div class="form-group">
                        <label for="cukup">Cukup</label>
                        <input type="text" name="cukup" class="form-control" id="str-cukup">
                    </div>
                    <div class="form-group">
                        <label for="baik">Baik</label>
                        <input type="text" name="baik" class="form-control" id="str-baik">
                    </div>
                    <div class="form-group">
                        <label for="kurang">Kurang</label>
                        <input type="text" name="kurang" class="form-control" id="str-kurang">
                    </div>
                    <div class="form-group">
                        <label for="rata_nilai">rata_nilai</label>
                        <input type="text" name="rata_nilai" class="form-control" id="str-rata_nilai">
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" class="form-control" id="str-note"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tgl_upd">Tanggal Update</label>
                        <input type="date" name="tgl_upd" class="form-control" id="str-tgl_upd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="boardboard" tabindex="-1" role="dialog" aria-labelledby="boardboardLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="boardboardLabel">Edit Dashboard SMKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="dash-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="smkk_jenis_id">Jenis SMKK</label>
                    <select data-plugin-selectTwo class="form-control" id="dash-smkk_jenis_id">
                        <?php foreach ($jenis_smkk as $jmk): ?>
                            <option value="<?= $jmk->id; ?>"><?= $jmk->nama_smkk; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="memuaskan">Memuaskan</label>
                    <input type="text" name="memuaskan" class="form-control" id="dash-memuaskan">
                </div>
                <div class="form-group">
                    <label for="baik">Baik</label>
                    <input type="text" name="baik" class="form-control" id="dash-baik">
                </div>
                <div class="form-group">
                    <label for="cukup">Cukup</label>
                    <input type="text" name="cukup" class="form-control" id="dash-cukup">
                </div>
                <div class="form-group">
                    <label for="kurang">Kurang</label>
                    <input type="text" name="kurang" class="form-control" id="dash-kurang">
                </div>
                <div class="form-group">
                    <label for="rata_nilai">Rata Nilai</label>
                    <input type="text" name="rata_nilai" class="form-control" id="dash-rata_nilai">
                </div>
                <div class="form-group">
                    <label for="note">Note</label>
                    <textarea type="text" name="note" class="form-control" id="dash-note"></textarea>
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="dash-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateDash()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    function updateData() {
        var id = document.getElementById("edit-id").value;
        var smkk_jenis_id = $("#edit-smkk_jenis_id").val();
        var tertib = $("#edit-tertib").val();
        var tidak_tertib = $("#edit-tidak_tertib").val();
        var jml_kecelakaan = $("#edit-jml_kecelakaan").val();
        var total_jam_kerja = $("#edit-total_jam_kerja").val();
        var note = $("#edit-note").val();
        var tgl_upd = $("#edit-tgl_upd").val();

        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateDokumen', // Adjust as needed for your update endpoint
            data: {
                id: id,
                smkk_jenis_id: smkk_jenis_id,
                tgl_upd: tgl_upd,
                tertib: tertib,
                tidak_tertib: tidak_tertib,
                jml_kecelakaan: jml_kecelakaan,
                total_jam_kerja: total_jam_kerja,
                note: note,
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDokumen').modal('hide');
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


    function editdokumen(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("edit-id").setAttribute('value', dataId); // Correct hidden ID field
        $('#editDokumen').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailDokSMKK',
            data: {
                id: dataId
            }, // Send dataId as an object
            dataType: 'json',
            success: function(response) {
                if (response && response.length > 0) {
                    var item = response[0]; // Assuming the response contains an array of items
                    console.log(item); // Check the data in the console

                    // Set the values correctly in the modal fields
                    $("#edit-smkk_jenis_id").val(item.smkk_jenis_id).trigger('change');
                    document.getElementById("edit-tertib").value = item.tertib;
                    document.getElementById("edit-tidak_tertib").value = item.tidak_tertib;
                    document.getElementById("edit-jml_kecelakaan").value = item.jml_kecelakaan;
                    document.getElementById("edit-total_jam_kerja").value = item.total_jam_kerja;
                    document.getElementById("edit-note").value = item.note;

                    // Ensure tgl_upd is formatted correctly as yyyy-mm-dd
                    const formattedDate = new Date(item.tgl_upd).toISOString().split('T')[0];
                    document.getElementById("edit-tgl_upd").value = formattedDate;
                }
            }
        });
        return false;
    }

    $(document).ready(function() {
        $('#formSMKK').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dikirim secara default

            $.ajax({
                url: '<?= base_url('storeSMKKDokumen'); ?>', // Endpoint tujuan
                type: 'POST',
                data: {
                    smkk_jenis_id: $('#smkk_jenis_id').val(),
                    tertib: $('#tertib').val(),
                    tidak_tertib: $('#tidak_tertib').val(),
                    jml_kecelakaan: $('#jml_kecelakaan').val(),
                    total_jam_kerja: $('#total_jam_kerja').val(),
                    note: $('#note').val(),
                    tgl_upd: $('#tgl_upd').val(),
                },
                dataType: 'json', // Tipe respon yang diharapkan
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tambahSMKK').modal('hide');
                            window.setTimeout(function() {
                                location.reload(); // Reload halaman setelah sukses
                            }, 2000);
                        });
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
        });
    });


    $(document).ready(function() {
        $('#formSMKKDashboard').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dikirim secara default

            $.ajax({
                url: '<?= base_url('storeSMKKDashboard'); ?>', // Endpoint tujuan
                type: 'POST',
                data: {
                    smkk_jenis_id: $('#str-smkk_jenis_id').val(),
                    memuaskan: $('#str-memuaskan').val(),
                    baik: $('#str-baik').val(),
                    cukup: $('#str-cukup').val(),
                    kurang: $('#str-kurang').val(),
                    rata_nilai: $('#str-rata_nilai').val(),
                    note: $('#str-note').val(),
                    tgl_upd: $('#str-tgl_upd').val(),
                },
                dataType: 'json', // Tipe respon yang diharapkan
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tambahSMKK').modal('hide');
                            window.setTimeout(function() {
                                location.reload(); // Reload halaman setelah sukses
                            }, 2000);
                        });
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
        });
    });


    function boardboard(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("dash-id").setAttribute('value', dataId); // Correct hidden ID field
        $('#boardboard').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailSMKKDash',
            data: {
                id: dataId
            }, // Send dataId as an object
            dataType: 'json',
            success: function(response) {
                if (response && response.length > 0) {
                    var item = response[0]; // Assuming the response contains an array of items
                    console.log(item); // Check the data in the console

                    // Set the values correctly in the modal fields
                    $("#dash-smkk_jenis_id").val(item.smkk_jenis_id).trigger('change');
                    document.getElementById("dash-memuaskan").value = item.memuaskan;
                    document.getElementById("dash-cukup").value = item.cukup;
                    document.getElementById("dash-baik").value = item.baik;
                    document.getElementById("dash-kurang").value = item.kurang;
                    document.getElementById("dash-rata_nilai").value = item.rata_nilai;
                    document.getElementById("dash-note").value = item.note;

                    // Ensure tgl_upd is formatted correctly as yyyy-mm-dd
                    const formattedDate = new Date(item.tgl_upd).toISOString().split('T')[0];
                    document.getElementById("dash-tgl_upd").value = formattedDate;
                }
            }
        });
        return false;
    }

    function updateDash() {
        var id = document.getElementById("dash-id").value;
        var smkk_jenis_id = $("#dash-smkk_jenis_id").val();
        var memuaskan = $("#dash-memuaskan").val();
        var baik = $("#dash-baik").val();
        var cukup = $("#dash-cukup").val();
        var kurang = $("#dash-kurang").val();
        var rata_nilai = $("#dash-rata_nilai").val();
        var note = $("#dash-note").val();
        var tgl_upd = $("#dash-tgl_upd").val();

        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateDash', // Adjust as needed for your update endpoint
            data: {
                id: id,
                smkk_jenis_id: smkk_jenis_id,
                tgl_upd: tgl_upd,
                memuaskan: memuaskan,
                baik: baik,
                cukup: cukup,
                rata_nilai: rata_nilai,
                note: note,
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDashboard').modal('hide');
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
</script>

<?= $this->endSection() ?>
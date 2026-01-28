<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<?php if (user()->username == 'admin') : ?>
    <button class="btn btn-outline-success" data-toggle="modal" data-target="#tambahVideo">
        Tambah Video Progress <i class="fa fa-plus"></i>
    </button>
<?php endif; ?>
<div class="row mt-2">
    <!-- Card 1 -->
    <?php foreach ($video as $vdo) { ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <iframe class="card-img-top" src="<?= $vdo->link_video; ?>" height="200" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <p class="text-center font-weight-bold"><?= $vdo->nama_video; ?></p>
            <?php if (user()->username == 'admin') : ?>
                <button class="btn btn-sm btn-warning"
                    data-toggle="modal"
                    data-target="#editvideo"
                    onclick="editvideo(this)"
                    data-id="<?= esc($vdo->id); ?>">
                    <i class="fi fi-tr-file-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger"
                    data-toggle="modal"
                    data-target="#deletevideo"
                    onclick="deletvideo(<?= esc($vdo->id); ?>)">
                    <i class="fi fi-tr-file-edit"></i>
                </button>
            <?php endif; ?>
        </div>
    <?php } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahVideo" tabindex="-1" role="dialog" aria-labelledby="tambahVideoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahVideoLabel">Tambah Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Video</label>
                    <input type="text" name="nama_video" class="form-control" id="nama_video">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Link Video</label>
                    <input type="text" name="link_video" class="form-control" id="link_video">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDataVideo()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editvideo" tabindex="-1" role="dialog" aria-labelledby="editvideoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editvideoLabel">Edit Data Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="vdo-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">Nama Video</label>
                    <input type="text" name="nama_video" class="form-control" id="vdo-nama_video">
                </div>
                <div class="form-group">Link Video</label>
                    <input type="text" name="link_video" class="form-control" id="vdo-link_video">
                </div>
                <div class="form-group">
                    <label for="tgl_upd">Tanggal Update</label>
                    <input type="date" name="tgl_upd" class="form-control" id="vdo-tgl_upd">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateVideo()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" id="deletevideo" tabindex="-1" role="dialog" aria-labelledby="deleteVideoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteVideoLabel">Hapus Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus video ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    function editvideo(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("vdo-id").setAttribute('value', dataId);
        $('#editvideo').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailDataVideo',
            data: 'id=' + dataId,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Check the data in the console
                $.each(response, function(i, item) {
                    document.getElementById("vdo-nama_video").value = item.nama_video;
                    document.getElementById("vdo-link_video").value = item.link_video;
                    document.getElementById("vdo-tgl_upd").value = item.tgl_upd;
                });
            }
        });
        return false;
    }

    function saveDataVideo() {
        $.ajax({
            url: '<?= base_url(); ?>storeVideo', // Replace with your actual endpoint
            method: 'POST',
            data: {
                nama_video: $('input[name="nama_video"]').val(),
                link_video: $('input[name="link_video"]').val(),
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
                        $('#tambahVideo').modal('hide');
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

    function updateVideo() {
        var id = document.getElementById("vdo-id").value;
        var nama_video = $("#vdo-nama_video").val();
        var link_video = $("#vdo-link_video").val();
        var tgl_upd = $("#vdo-tgl_upd").val();


        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateVideo', // Adjust as needed for your update endpoint
            data: {
                id: id,
                nama_video: nama_video,
                link_video: link_video,
                tgl_upd: tgl_upd
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editvideo').modal('hide');
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

    function deletvideo(id) {
        deleteId = id; // Set id ke variabel global untuk dihapus
        $('#deletevideo').modal('show'); // Tampilkan modal
    }

    function confirmDelete() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>deleteVideo', // Endpoint API untuk hapus video
            data: {
                id: deleteId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#deletevideo').modal('hide');
                        location.reload(); // Refresh halaman setelah hapus berhasil
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
                    text: 'Terjadi kesalahan saat menghapus data.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Content Row -->
<?php foreach ($last_upd_data as $tgl_upd): ?>
    <p>Data Upd : <?= date('F', strtotime($tgl_upd->tgl_progress)); // Convert to month name 
                        ?> <?= date('d, Y', strtotime($tgl_upd->tgl_progress)); // Display day and year 
                            ?></p>
<?php endforeach; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <?php if (user()->username == 'admin') : ?>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#clashDetection">
            Perbaru data Clash Detection<i class="fa fa-plus"></i>
        </button>
    <?php endif; ?>
    <!-- Input filter dan tombol filter di sebelah kanan -->
    <div class="d-flex align-items-center">
        <form method="get" action="<?= base_url('resume/clash-detection'); ?>" class="d-flex justify-content-end">
            <select name="tgl_upd" id="tgl_upd" class="form-control me-2">
                <option value="00">Pilih tanggal</option>
                <?php foreach ($option_waktu as $data): ?>
                    <option value="<?= $data->tgl_progress; ?>"><?= $data->tgl_progress; ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-primary ml-2">Filter</button>
            <a href="<?= base_url('resume/clash-detection'); ?>" class="btn btn-warning ml-2">Reset</a>
        </form>
    </div>
</div>
<div class="row mt-2">
    <!-- Area Chart -->
    <div class="col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <?php foreach ($last_upd_data as $lst) { ?>
    <div class="row">
        <!-- TOTAL -->
        <div class="col-md-4 col-12">
            <div class="card shadow mb-4 bg-secondary">
                <div class="card-body text-center text-white">
                    <i class="fi fi-tr-assessment fa-2x mb-2 d-block"></i>
                    <h6 class="font-weight-bold mb-1">Total</h6>
                    <h5>
                        <?php
                            $total = $lst->open + $lst->close;
                            echo $total;
                        ?>
                    </h5>
                </div>
            </div>
        </div>

        <!-- CLOSED -->
        <div class="col-md-4 col-12">
            <div class="card shadow mb-4 bg-primary">
                <div class="card-body text-center text-white">
                    <i class="fi fi-tr-times-hexagon fa-2x mb-2 d-block"></i>
                    <h6 class="font-weight-bold mb-1">Closed</h6>
                    <h5><?= $lst->close; ?></h5>
                </div>
            </div>
        </div>

        <!-- OPEN -->
        <div class="col-md-4 col-12">
            <div class="card shadow mb-4 bg-success">
                <div class="card-body text-center text-white">
                    <i class="fi fi-tr-light-emergency-on fa-2x mb-2 d-block"></i>
                    <h6 class="font-weight-bold mb-1">Open</h6>
                    <h5><?= $lst->open; ?></h5>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    </div>
</div>
<div class="col-xl-12 col-lg-7">
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="text-dark">Resume Progress Detection</h5>
            <div class="d-flex justify-content-end mb-2">
                <small class="text-white badge badge-success">
                    <?php foreach ($last_upd_data as $lst) { ?>
                        Last updated: <?= $lst->tgl_progress; ?>
                    <?php } ?>
                </small>
                <small class="text-white badge badge-warning ml-2">
                    Tahun : 2024
                </small>
            </div>
            <table class="display table-bordered table-striped text-center" style="width:100%">
                <thead>
                    <tr class="text-white bg-primary">
                        <th>Bulan</th>
                        <th>Tanggal</th>
                        <th>Closed</th>
                        <th>Open</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groupedData as $month => $records): ?>
                        <?php foreach ($records as $index => $record): ?>
                            <tr>
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?= count($records) ?>" class="group"><?= $month ?></td>
                                <?php endif; ?>
                                <td><?= $record['day'] ?></td>
                                <td><?= $record['closed'] ?></td>
                                <td><?= $record['open'] ?> <?php if (user()->username == 'admin') : ?>
                                        <button
                                            class="btn btn-outline-warning float-right"
                                            onclick="edit(this)"
                                            data-id="<?= $record['id'] ?>">
                                            <i class="fi fi-tr-file-edit"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                                <!-- Tambahkan kolom baru untuk tombol Edit -->
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="clashDetection" tabindex="-1" role="dialog" aria-labelledby="clashDetectionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="clashDetectionLabel">Update Clash Detection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Tanggal Progress</label>
                    <input type="date" name="tgl_progress" class="form-control" id="tgl_progress">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Open</label>
                            <input type="text" name="open" class="form-control" id="open">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Close</label>
                            <input type="text" name="close" class="form-control" id="close">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveDataCD()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit Data Pelaksanaan -->
<div class="modal fade" id="editDataClashDetection" tabindex="-1" role="dialog" aria-labelledby="editDataClashDetectionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editDataClashDetectionLabel">Edit Resume Clash Detection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id"> <!-- Hidden input to store the ID -->
                <div class="form-group">
                    <label for="tgl_progress">Tanggal Progress</label>
                    <input type="date" name="tgl_progress" class="form-control" id="edit-tgl_progress">
                </div>
                <div class="form-group">
                    <label for="open">Open</label>
                    <input type="text" name="open" class="form-control" id="edit-open">
                </div>
                <div class="form-group">
                    <label for="close">Close</label>
                    <input type="text" name="close" class="form-control" id="edit-close">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateData()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>

</script>

<script>
    function edit(elem) {
        var dataId = $(elem).data("id");
        document.getElementById("edit-id").setAttribute('value', dataId);
        $('#editDataClashDetection').modal();
        $.ajax({
            type: 'GET',
            url: '<?= base_url() ?>detailClashDetection',
            data: 'id=' + dataId,
            dataType: 'json',
            success: function(response) {
                console.log(response); // Check the data in the console
                $.each(response, function(i, item) {
                    document.getElementById("edit-open").value = item.open;
                    document.getElementById("edit-close").value = item.close;
                    document.getElementById("edit-tgl_progress").value = item.tgl_progress;
                });
            }


        });
        return false;
    }


    function updateData() {
        var id = document.getElementById("edit-id").value;
        var tgl_progress = $("#edit-tgl_progress").val();
        var open = $("#edit-open").val();
        var close = $("#edit-close").val();

        // AJAX request to save data
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>updateClashDetection', // Adjust as needed for your update endpoint
            data: {
                id: id,
                tgl_progress: tgl_progress,
                open: open,
                close: close,
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Close the modal
                    $('#editDataClashDetection').modal('hide');
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

    $(document).ready(function() {
        $('#myTable').DataTable({
            "rowGroup": {
                "dataSrc": 0 // Group by the first column (Bulan)
            },
            "order": [
                [1, 'asc']
            ] // Sort by Tanggal
        });
    });
</script>

<script>
    // Ambil data clash_detection dari server langsung dari view
    const clashDetectionData = <?= json_encode($clash_detection); ?>;

    // Pastikan format data adalah array
    if (!Array.isArray(clashDetectionData)) {
        console.error('Data format is incorrect');
    } else {
        // Persiapkan data untuk chart
        const labels = clashDetectionData.map(item => item.tgl_progress);
        const rencanaData = clashDetectionData.map(item => item.open);
        const realisasiData = clashDetectionData.map(item => item.close);

        // Buat chart menggunakan Chart.js untuk Rencana vs Realisasi
        const renrelCtx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(renrelCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Open',
                        data: rencanaData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Close',
                        data: realisasiData,
                        backgroundColor: 'rgba(255, 15, 15, 0.7)',
                        borderColor: 'rgba(255, 15, 15, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false // Disable horizontal grid lines
                        },
                        ticks: {
                            font: {
                                family: 'Montserrat',
                                size: 12
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
                            size: 10
                        },
                        offset: 2
                    }
                }
            },
            plugins: [ChartDataLabels] // Enable the plugin for data labels
        });
    }

    function saveDataCD() {
        $.ajax({
            url: '<?= base_url(); ?>storeDataClashDetection', // Replace with your actual endpoint
            method: 'POST',
            data: {
                open: $('input[name="open"]').val(),
                close: $('input[name="close"]').val(),
                tgl_progress: $('input[name="tgl_progress"]').val(),
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
</script>
<?= $this->endSection() ?>
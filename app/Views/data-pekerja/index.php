<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Content Row -->
<?php foreach ($last_upd_data as $tgl_upd): ?>
    <p>Status Data : <?= date('F', strtotime($tgl_upd->tgl_upd)); // Convert to month name 
                        ?> <?= date('d, Y', strtotime($tgl_upd->tgl_upd)); // Display day and year 
                            ?></p>
<?php endforeach; ?>
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="head-badge-card text-white">Detail Data Pekerja</h5>
                <?php if (user()->username == 'admin') : ?>
                    <button class="btn btn-success mb-2 float-right" data-toggle="modal" data-target="#tambahDataPekerja">
                        Tambah Data Detail Pekerja <i class="fa fa-plus"></i>
                    </button>
                <?php endif; ?>
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center text-white bg-primary">No</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">No Index Paket</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">Unor</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">Nama Paket</th> <!-- Kolom utama -->
                            <th rowspan="2" class="text-center text-white bg-primary">Nama Kontraktor</th> <!-- Kolom utama -->
                            <th colspan="2" class="text-center text-white bg-primary">Data Real Pekerja Lap.</th> <!-- Kolom dengan sub-kolom -->
                            <th rowspan="2" class="text-center text-white bg-primary">Total Tenaga Kerja</th> <!-- Kolom dengan sub-kolom -->
                        </tr>
                        <tr>
                            <th class="text-center text-white bg-primary">Lokal</th>
                            <th class="text-center text-white bg-primary">Luar</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $no = 1;
                        $total_lokal = 0;
                        $total_luar = 0;
                        $total_tenaga_kerja = 0;
                        foreach ($data_pekerja_detail as $dtp) {
                            $total_lokal += $dtp->lokal;
                            $total_luar += $dtp->luar;
                            $total_tenaga_kerja += $dtp->total_tenaga_kerja;
                        ?>

                            <tr>
                                <td><?= $dtp->id; ?></td>
                                <td> <?php if (user()->username == 'admin') : ?>
                                        <br>
                                        <button class="btn btn-sm btn-warning float-right"
                                            data-toggle="modal"
                                            data-target="#editDataPekerja"
                                            onclick="editdatapekerja(this)"
                                            data-id="<?= esc($dtp->id); ?>">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger float-right"
                                            data-toggle="modal"
                                            data-target="#deleteDataPekerja"
                                            onclick="setDeleteId(<?= esc($dtp->id); ?>)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?= $dtp->no_index_paket ?>
                                </td>
                                <td><?= $dtp->unor ?></td>
                                <td><?= $dtp->nama_paket ?></td>
                                <td><?= $dtp->nama_kontraktor ?></td>
                                <td><?= $dtp->lokal ?></td>
                                <td><?= $dtp->luar ?></td>
                                <td><?= $dtp->total_tenaga_kerja ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahDataPekerja" tabindex="-1" role="dialog" aria-labelledby="tambahDataPekerjaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="tambahDataPekerjaLabel">Tambah Data Pekerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="tambahDataPekerja" action="<?= base_url('storeDataPekerja'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <select data-plugin-selectTwo class="form-control" name="data_pekerja_id" id="data_pekerja_id">
                                <?php foreach ($data_pekerja as $dpd): ?>
                                    <option value="<?= $dpd->id; ?>"><?= $dpd->nama_data_pekerja; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_index_paket">No Index Paket</label>
                            <input type="text" name="no_index_paket" class="form-control" id="no_index_paket">
                        </div>
                        <div class="form-group">
                            <label for="unor">Unor</label>
                            <input type="text" name="unor" class="form-control" id="unor">
                        </div>
                        <div class="form-group">
                            <label for="nama_paket">Nama Paket</label>
                            <input type="text" name="nama_paket" class="form-control" id="nama_paket">
                        </div>
                        <div class="form-group">
                            <label for="nama_kontraktor">Nama Kontraktor</label>
                            <input type="text" name="nama_kontraktor" class="form-control" id="nama_kontraktor">
                        </div>
                        <div class="form-group">
                            <label for="lokal">Lokal</label>
                            <input type="number" name="lokal" class="form-control" id="lokal" oninput="calculateTotal2()">
                        </div>
                        <div class="form-group">
                            <label for="luar">Luar</label>
                            <input type="number" name="luar" class="form-control" id="luar" oninput="calculateTotal2()">
                        </div>
                        <div class="form-group">
                            <label for="total_tenaga_kerja">Total Tenaga Kerja</label>
                            <input type="text" name="total_tenaga_kerja" class="form-control" id="total_tenaga_kerja" readonly>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteDataPekerja" tabindex="-1" role="dialog" aria-labelledby="deleteDataPekerjaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteDataPekerjaLabel">Delete Data Pekerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteData()">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editDataPekerja" tabindex="-1" role="dialog" aria-labelledby="editDataPekerjaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editDataPekerjaLabel">Edit Data Pekerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dpk-id"> <!-- Hidden input to store the ID -->
                    <div class="form-group">
                        <select data-plugin-selectTwo class="form-control" name="data_pekerja_id" id="dpk-data_pekerja_id">
                            <?php foreach ($data_pekerja as $dpd): ?>
                                <option value="<?= $dpd->id; ?>"><?= $dpd->nama_data_pekerja; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_index_paket">No Paket Index</label>
                        <input type="text" name="no_index_paket" class="form-control" id="dpk-no_index_paket">
                    </div>
                    <div class="form-group">
                        <label for="unor">Unor</label>
                        <input type="text" name="unor" class="form-control" id="dpk-unor">
                    </div>
                    <div class="form-group">
                        <label for="nama_paket">Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" id="dpk-nama_paket">
                    </div>
                    <div class="form-group">
                        <label for="nama_kontraktor">Nama Kontraktor</label>
                        <input type="text" name="nama_kontraktor" class="form-control" id="dpk-nama_kontraktor">
                    </div>
                    <div class="form-group">
                        <label for="lokal">Lokal</label>
                        <input type="number" name="lokal" class="form-control" id="dpk-lokal" oninput="calculateTotal()">
                    </div>
                    <div class="form-group">
                        <label for="luar">Luar</label>
                        <input type="number" name="luar" class="form-control" id="dpk-luar" oninput="calculateTotal()">
                    </div>
                    <div class="form-group">
                        <label for="total_tenaga_kerja">Total Tenaga Kerja</label>
                        <input type="text" name="total_tenaga_kerja" class="form-control" id="dpk-total_tenaga_kerja" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tgl_upd">Tanggal Update</label>
                        <input type="date" name="tgl_upd" class="form-control" id="dpk-tgl_upd">
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
        $(document).ready(function() {
            $('#myTable').DataTable({});
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        function calculateTotal() {
            const lokal = parseInt(document.getElementById('dpk-lokal').value) || 0;
            const luar = parseInt(document.getElementById('dpk-luar').value) || 0;
            const total = lokal + luar;
            document.getElementById('dpk-total_tenaga_kerja').value = total;
        }

        function calculateTotal2() {
            const lokal = parseInt(document.getElementById('lokal').value) || 0;
            const luar = parseInt(document.getElementById('luar').value) || 0;
            const total = lokal + luar;
            document.getElementById('total_tenaga_kerja').value = total;
        }

        const totalLokal = <?= $total_lokal ?>;
        const totalLuar = <?= $total_luar ?>;
        const totalTenagaKerja = <?= $total_tenaga_kerja ?>;

        const ctx = document.getElementById('myChart').getContext('2d');

        // Prepare data for the chart
        const chartData = {
            labels: ['Lokal', 'Luar', 'Total'], // Adding 'Total' as a label
            datasets: [{
                label: '',
                data: [totalLokal, totalLuar, totalTenagaKerja],
                backgroundColor: [
                    'rgba(54, 162, 235, 1)', // Color for Lokal
                    'rgba(242, 147, 5, 1)', // Color for Luar
                    'rgba(75, 192, 192, 1)' // Color for Total
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(242, 147, 5, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Create the bar chart
        const myChart = new Chart(ctx, {
            type: 'bar', // Change the type to 'bar'
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true, // Start y-axis at zero
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                        align: 'center',
                        labels: {
                            font: {
                                family: 'Montserrat',
                                size: 12,
                                weight: 'normal'
                            },
                            usePointStyle: true,
                            boxWidth: 10
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


        function editdatapekerja(button) {
            // Dapatkan ID dari atribut data-id pada tombol yang diklik
            var id = $(button).data('id');

            // Setel ID ke input tersembunyi di modal
            $('#dpk-id').val(id);

            // Lakukan AJAX atau lainnya untuk mendapatkan detail pekerja berdasarkan ID
            $.ajax({
                url: '<?= base_url("detailDataPekerja"); ?>/' + id, // Endpoint untuk mengambil data pekerja berdasarkan ID
                method: 'GET',
                success: function(data) {
                    // Isi data modal dengan nilai yang diterima dari respons
                    $('#dpk-data_pekerja_id').val(data.data_pekerja_id);
                    $('#dpk-no_index_paket').val(data.no_index_paket);
                    $('#dpk-unor').val(data.unor);
                    $('#dpk-nama_paket').val(data.nama_paket);
                    $('#dpk-nama_kontraktor').val(data.nama_kontraktor);
                    $('#dpk-lokal').val(data.lokal);
                    $('#dpk-luar').val(data.luar);
                    $('#dpk-total_tenaga_kerja').val(data.total_tenaga_kerja);
                    $('#dpk-tgl_upd').val(data.tgl_upd);
                },
                error: function(err) {
                    console.log('Error:', err);
                }
            });
        }

        function updateData() {
            let id = $('#dpk-id').val();
            let data_pekerja_id = $('#dpk-data_pekerja_id').val();
            let no_index_paket = $('#dpk-no_index_paket').val();
            let unor = $('#dpk-unor').val();
            let nama_paket = $('#dpk-nama_paket').val();
            let nama_kontraktor = $('#dpk-nama_kontraktor').val();
            let lokal = $('#dpk-lokal').val();
            let luar = $('#dpk-luar').val();
            let total_tenaga_kerja = $('#dpk-total_tenaga_kerja').val();
            let tgl_upd = $('#dpk-tgl_upd').val();

            $.post('<?= base_url('updateDetailPekerja'); ?>', {
                id: id, // Ensure 'id' is sent
                data_pekerja_id: data_pekerja_id,
                no_index_paket: no_index_paket,
                unor: unor,
                nama_paket: nama_paket,
                nama_kontraktor: nama_kontraktor,
                lokal: lokal,
                luar: luar,
                total_tenaga_kerja: total_tenaga_kerja,
                tgl_upd: tgl_upd
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



        $(document).ready(function() {
            $('#tambahDataPekerja').on('submit', function(e) {
                e.preventDefault(); // Mencegah form dikirim secara default

                $.ajax({
                    url: '<?= base_url('storeDataPekerja'); ?>', // Endpoint tujuan
                    type: 'POST',
                    data: {
                        data_pekerja_id: $('#data_pekerja_id').val(),
                        no_index_paket: $('#no_index_paket').val(),
                        unor: $('#unor').val(),
                        nama_paket: $('#nama_paket').val(),
                        nama_kontraktor: $('#nama_kontraktor').val(),
                        lokal: $('#lokal').val(),
                        luar: $('#luar').val(),
                        total_tenaga_kerja: $('#total_tenaga_kerja').val(),
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
                                $('#tambahDataPekerja').modal('hide');
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


        let deleteId = null;

        function setDeleteId(id) {
            deleteId = id; // Set the ID of the worker to be deleted
        }

        function deleteData() {
            if (deleteId) {
                // Proceed with AJAX request if confirmed
                $.ajax({
                    url: '<?= base_url('deleteDataPekerja'); ?>',
                    type: 'POST',
                    data: {
                        id: deleteId // Send the ID in the request body
                    },
                    success: function(result) {
                        // Handle success
                        $('#deleteDataPekerja').modal('hide');
                        // Show success alert
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        location.reload(); // Reload the page to see changes
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error deleting data',
                            text: error
                        });
                    }
                });
            }
        }




        function calculateTotal() {
            const lokal = parseInt(document.getElementById('dpk-lokal').value) || 0;
            const luar = parseInt(document.getElementById('dpk-luar').value) || 0;
            const total = lokal + luar;
            document.getElementById('dpk-total_tenaga_kerja').value = total;
        }
    </script>




    <?= $this->endSection() ?>
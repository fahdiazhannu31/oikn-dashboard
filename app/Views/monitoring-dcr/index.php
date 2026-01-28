<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="card">
        <div class="card-body overflow-hidden">
            <div id="loading-spinner" class="text-center">
                <div class="spinner-border" role="status">
                </div>
               <p>Memproses data DCR. Harap tunggu, estimasi waktu 10-20 detik...</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-hover table-striped" id="data-table" style="display: none;font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width: 15%;color:white;background-color:lightslategray;vertical-align:middle;">POSISI</th>
                                <th colspan="2" style="width: 15%;text-align:center;color:black;background-color:lightgreen;font-size:10px;vertical-align:middle;"><b>BLM TERLAMBAT</b></th>
                                <th colspan="2" style="width: 15%;text-align:center;color:black;background-color:yellow;font-size:10px;vertical-align:middle;"><b>HAMPIR TERLAMBAT</b></th>
                                <th colspan="2" style="width: 15%;text-align:center;color:white;background-color:red;vertical-align:middle;">TERLAMBAT</th>
                                <th style="width: 15%;text-align:center;color:white;background-color:cadetblue;vertical-align:middle;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered table-hover table-striped" id="upload-table" style="display: none;font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width: 60%;color:white;background-color:lightslategray;text-align: center;" colspan="4">DOKUMEN UPLOAD</th>
                                <th colspan="2" style="width: 40%;color:white;background-color:lightslategray;text-align: center;">DOKUMEN TERAKHIR</th>
                            </tr>
                        </thead>
                        <tbody id="upload-data">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>

                    <table class="table table-bordered table-hover table-striped" id="category-table" style="display: none;font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="width: 55%;color:white;background-color:lightslategray;text-align: center;">KATEGORI</th>
                                <th style="width: 15%;color:white;background-color:lightslategray;text-align: center;">OPEN</th>
                                <th style="width: 15%;color:white;background-color:lightslategray;text-align: center;">PROSES</th>
                                <th style="width: 15%;color:white;background-color:lightslategray;text-align: center;">CLOSE</th>
                            </tr>
                        </thead>
                        <tbody id="category-data">
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="table-responsive"> <!-- Add this div to enable horizontal scrolling -->
               <table class="table table-bordered table-hover" id="dokumendata" style="font-size: 12px;">
    <thead class="bg-primary text-white">
        <tr>
            <th style="width: 3%; text-align: center;"></th>
            <th style="width: 3%; text-align: center;">DCR</th>
            <th style="width: 5%; text-align: center;">DIS</th>
            <th style="width: 5%; text-align: center;">KAT</th>
            <th style="width: 10%;">PT</th>
            <th style="width: 19%; text-align: center;">Nomor Dokumen</th>
            <th style="width: 35%; text-align: center;">Perihal</th>
            <th style="width: 10%; text-align: center;">Tanggal</th>
            <th style="width: 10%; text-align: center;">Target</th>
            <th style="width: 5%; text-align: center;">Posisi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
            </div>
        </div>
    </div>

    <!-- Add CSS to ensure the table is scrollable horizontally -->
    <style>
        .table-responsive {
            overflow-x: auto;
            /* Allows horizontal scrolling */
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling for mobile devices */
        }
    </style>


    <script>
        // Fetch data from the API
        fetch('http://tech.jayacm.co.id/dcr-ikn/login/monitoringnew')
            .then(response => response.json())
            .then(data => {
                // Hide the loading spinner
                document.getElementById('loading-spinner').style.display = 'none';

                // Show the tables
                document.getElementById('data-table').style.display = 'table';
                document.getElementById('upload-table').style.display = 'table';
                document.getElementById('category-table').style.display = 'table';

                // Populate the first table with data
                const tableData = document.getElementById('table-data');
                tableData.innerHTML = `
                <tr>
                    <td style="background-color:lightslategray;color:white;">JCM</td>
                    <td style="width:7%;text-align: center;background-color:lightgreen;color:black;">≥ 5Hr</td>
                    <td style="text-align: right;background-color:lightgreen;color:black;">${data.aman1}</td>
                    <td style="width:7%;text-align: right;color:black;background-color:yellow;">0-4Hr</td>
                    <td style="text-align: right;color:black;background-color:yellow;">${data.hptelat1}</td>
                    <td style="width:7%;text-align: right;color:white;background-color:red;"> < 0Hr</td>
                    <td style="text-align: right;color:white;background-color:red;">${data.telat1}</td>
                    <td style="text-align: right;background-color:cadetblue;color:white;">${data.total_jcm}</td>
                </tr>
                <tr>
                    <td style="background-color:lightslategray;color:white;">KELUAR</td>
                    <td style="width:7%;text-align: right;background-color:lightgreen;color:black;">≤ 3Hr</td>
                    <td style="text-align: right;background-color:lightgreen;color:black;">${data.aman2}</td>
                    <td style="width:7%;text-align: right;color:black;background-color:yellow;">4-7Hr</td>
                    <td style="text-align: right;color:black;background-color:yellow;">${data.hptelat2}</td>
                    <td style="width:7%;text-align: right;color:white;background-color:red;">> 7Hr</td>
                    <td style="text-align: right;color:white;background-color:red;">${data.telat2}</td>
                    <td style="text-align: right;background-color:cadetblue;color:white;">${data.total_keluar}</td>
                </tr>
                <tr>
                    <td style="background-color:lightslategray;color:white;">ARSIP</td>
                    <td colspan="2" style="text-align: right;background-color:lightgreen;color:black;">${data.aman4}</td>
                    <td colspan="2" style="background-color:yellow;color:white;"></td>
                    <td colspan="2" style="text-align: right;color:white;background-color:red;">${data.telat4}</td>
                    <td style="text-align: right;background-color:cadetblue;color:white;">${data.total_clsd}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="background-color:lightslategray;color:white;">ALL</td>
                    <td colspan="2" style="text-align: right;background-color:lightgreen;color:black;">${data.aman5}</td>
                    <td colspan="2" style="text-align: right;color:black;background-color:yellow;">${data.hptelat5}</td>
                    <td colspan="2" style="text-align: right;color:white;background-color:red;">${data.telat5}</td>
                    <td style="text-align: right;background-color:cadetblue;color:white;">${data.total_dokumen}</td>
                </tr>
            `;

                // Populate the second table (Dokumen Upload) with data
                const uploadData = document.getElementById('upload-data');

                const percentageSudah = (data.sudah / (data.sudah + data.belum)) * 100;
                const percentageBelum = (data.belum / (data.sudah + data.belum)) * 100;
                const percentageFormatted = percentageSudah.toFixed(2); // To get 2 decimal places
                const percentageFormattedBelum = percentageBelum.toFixed(2); // To get 2 decimal places

                uploadData.innerHTML = `
                  <tr>
                        <td style="background-color:lightslategray;color:white;text-align: center;">TOTAL</td>
                        <td style="background-color:lightslategray;color:white;text-align: center;">%</td>
                        <td style="background-color:lightslategray;color:white;text-align: center;">BELUM <a href="<?php echo base_url() ?>dcr/cetak_no_upload" target="_blank" style="color: white;"><i class="fa fa-print"></i></a></td>
                        <td style="background-color:lightslategray;color:white;text-align: center;">%</td>
                        <td style="background-color:lightslategray;color:white;text-align: center;">REGISTER</td>
                        <td style="background-color:lightslategray;color:white;text-align: center;">UPLOAD</td>
                    </tr>
                <tr>
                    <td style="text-align: center;">${data.sudah}</td>
                      <td style="text-align: center;">${data.sudah + data.belum > 0 ? percentageFormatted : '0'}</td>
                    <td style="text-align: center;">${data.belum}</td>
                    <td style="text-align: center;">${data.sudah + data.belum > 0 ? percentageFormattedBelum : '0'}</td>
                    <td style="text-align: center;">${data.tgl_register}</td>
                    <td style="text-align: center;">${data.tgl_upload}</td>
                </tr>
            `;

                // Populate the third table (Kategori) with data
                const categoryData = document.getElementById('category-data');
                categoryData.innerHTML = `
                <tr>
                    <td style="text-align: left;">ALL/UMUM</td>
                    <td style="text-align: center;">${data.open1}</td>
                    <td style="text-align: center;">${data.proses1}</td>
                    <td style="text-align: center;">${data.close1}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Pelaksanaan</td>
                    <td style="text-align: center;">${data.open2}</td>
                    <td style="text-align: center;">${data.proses2}</td>
                    <td style="text-align: center;">${data.close2}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Perencanaan</td>
                    <td style="text-align: center;">${data.open3}</td>
                    <td style="text-align: center;">${data.proses3}</td>
                    <td style="text-align: center;">${data.close3}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">KPI</td>
                    <td style="text-align: center;">${data.open4}</td>
                    <td style="text-align: center;">${data.proses4}</td>
                    <td style="text-align: center;">${data.close4}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Estate Management</td>
                    <td style="text-align: center;">${data.open5}</td>
                    <td style="text-align: center;">${data.proses5}</td>
                    <td style="text-align: center;">${data.close5}</td>
                </tr>
            `;
            })
            .catch(error => console.error('Error fetching data:', error));

        var tablecompany = $('#dokumendata').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "http://tech.jayacm.co.id/dcr-ikn/login/datamonitoringnew",
                "type": "GET"
            },
            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false,
            }, ],
        });
    </script>

    <?= $this->endSection() ?>
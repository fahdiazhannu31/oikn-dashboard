<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myBarChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                              <div class="card-body">
                              <h5 class="head-badge-card text-white">Resume Progress Pelaksanaan</h5>
                              <?php 
                                        $no = 1;
                                        foreach ($resume as $rsm) : ?>                            
                                    <!-- Tampilkan tanggal update di atas tabel -->
                                    <?php if (!empty($rsm)) : ?>
                                        <div class="d-flex justify-content-end mb-2">
                                            <small class="text-white badge badge-warning">
                                                Last updated: <?= date('d F Y', strtotime($rsm->tgl_upd)); ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center text-white bg-primary">No</th> <!-- Kolom utama -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Nama Paket</th> <!-- Kolom utama -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Rencana DED (Lembar)</th> <!-- Kolom utama -->
                                            <th colspan="3" class="text-center text-white bg-primary">Realisasi DED</th> <!-- Kolom dengan sub-kolom -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Upload CDE</th> <!-- Kolom dengan sub-kolom -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Keterangan</th> <!-- Kolom dengan sub-kolom -->
                                        </tr>
                                        <tr>
                                            <th class="text-center text-white bg-primary">Dari Perencana</th>
                                            <th class="text-center text-white bg-primary">Approve MK</th>
                                            <th class="text-center text-white bg-primary">Approve PPK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 
                                            
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td class="text-center"><?= $rsm->nama_paket; ?></td>
                                            <td class="text-middle"><?= $rsm->ren_ded; ?> %</td>
                                            <td class="text-middle"><?= $rsm->dari_perencana; ?> %</td>
                                            <td class="text-middle"><?= $rsm->approve_mk; ?> %</td>
                                            <td class="text-middle"><?= $rsm->approve_ppk; ?> %</td>
                                            <td class="text-middle"><?= $rsm->upl_cde; ?> %</td>
                                            <td class="text-middle"><?= $rsm->ket; ?></td>
                                        </tr>
                                        <?php endforeach ; ?>
                                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        // Fetch data for both charts
        const [response1, response2] = await Promise.all([
            fetch('/api/data-ded'), // Sesuaikan dengan endpoint API Anda
            fetch('/api/data-fisik')   // Sesuaikan dengan endpoint API Anda
        ]);

        const rawDataGrafik = await response1.json();
        const rawDataFisik = await response2.json();

        // Process data for the first chart (data-grafik)
        const labelsGrafik = [...new Set(rawDataGrafik.map(item => item.nama_paket))];
        const dedNames = [...new Set(rawDataGrafik.map(item => item.nama_ded))];

        const datasetsGrafik = dedNames.map(ded => {
            const data = labelsGrafik.map(paket => {
                const entry = rawDataGrafik.find(item => item.nama_paket === paket && item.nama_ded === ded);
                return entry ? entry.jml_paket : 0; // Jika tidak ada, set ke 0
            });

            return {
                label: ded,
                data: data,
                backgroundColor: getColor(ded), // Get color based on bidang
            };
        });

        // Chart configuration for myBarChart
        const ctxX = document.getElementById('myBarChart').getContext('2d');
        const configBarChart = {
            type: 'bar',
            data: {
                labels: labelsGrafik,
                datasets: datasetsGrafik,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

        // Process data for the second chart (data-FISIK)
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

    // Function to get color based on bidang for the first chart
    function getColor(ded) {
        switch (ded) {
            case 'Dari Perencana': return 'rgba(41, 134, 255, 0.8)';  // Biru
            case 'Approved By MK': return 'rgba(240, 74, 74, 0.8)';  // Merah
            case 'Approved By PPK': return 'rgba(255, 255, 92, 0.8)';  // Kuning
            case 'UPLOAD CDE': return 'rgba(102, 255, 102, 0.5)';  // Hijau (dengan transparansi)
            default: return 'rgba(153, 102, 255, 1)';  // Warna default
        }
    }

    // Function to get color based on batch for the second chart
    function getColorFisik(batch) {
        switch (batch) {
            case 'Batch 1': return 'rgba(54, 162, 235, 1)';
            case 'Batch 2': return 'rgba(255, 206, 86, 1)';
            case 'Batch 3': return 'rgba(255, 99, 132, 1)';
            default: return 'rgba(153, 102, 255, 1)';
        }
    }
</script>


                    
<?= $this->endSection() ?>
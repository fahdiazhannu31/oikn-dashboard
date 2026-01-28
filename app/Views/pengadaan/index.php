<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <?php foreach ($pengadaan as $plk): ?>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-2xl font-weight-bold text-dark text-uppercase mb-1">
                                                    <?= $plk->nama_batch; ?>
                                                </div>
                                                <div class="text-xs font-weight-bold text-dark text-uppercase">
                                                    <?= $plk->ket_1; ?> <br>
                                                </div>
                                                <div class="h5 mb-2 font-weight-bold text-primary">
                                                    <span class="badge badge-primary custom-badge">109 Paket</span>
                                                </div>
                                                <div class="text-xs font-weight-bold text-dark text-uppercase">
                                                    <?= $plk->ket_2; ?> <br>
                                                </div>
                                                <div class="h5 mb-2 font-weight-bold text-danger">
                                                    <span class="badge badge-danger custom-badge">Rp 25,031 T</span>
                                                </div>
                                                <div class="text-xs font-weight-bold text-dark text-uppercase">
                                                    <?= $plk->ket_3; ?> <br>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-success">
                                                    <span class="badge badge-success custom-badge">93,9122%</span>
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

                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                              <div class="card-body">
                              <h5 class="head-badge-card text-white">Resume Progress Pelaksanaan</h5>
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center text-white bg-primary">No</th> <!-- Kolom utama -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Unor</th> <!-- Kolom utama -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Nama Paket</th> <!-- Kolom utama -->
                                            <th colspan="3" class="text-center text-white bg-primary">Progress Fisik MYC (%)</th> <!-- Kolom dengan sub-kolom -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Status</th> <!-- Kolom dengan sub-kolom -->
                                            <th rowspan="2" class="text-center text-white bg-primary">Isu</th> <!-- Kolom dengan sub-kolom -->
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
                                            <td><?= $rsm->unor; ?></td>
                                            <td class="text-center"><?= $rsm->nama_paket; ?></td>
                                            <td class="text-middle"><?= $rsm->rencana; ?> %</td>
                                            <td class="text-middle"><?= $rsm->realisasi; ?> %</td>
                                            <td class="text-middle"><?= $rsm->deviasi; ?> %</td>
                                            <td class="text-middle <?= ($rsm->deviasi < 0) ? 'bg-overtime text-white' : '' ?>"><?= $rsm->status; ?></td>
                                            <td><?= $rsm->isu; ?></td>
                                        </tr>
                                        <?php endforeach ; ?>
                                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                                    </tbody>
                                </table>
                                </div>
                            </div>
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
            fetch('/api/data-grafik'), // Sesuaikan dengan endpoint API Anda
            fetch('/api/data-fisik')   // Sesuaikan dengan endpoint API Anda
        ]);

        const rawDataGrafik = await response1.json();
        const rawDataFisik = await response2.json();

        // Process data for the first chart (data-grafik)
        const labelsGrafik = [...new Set(rawDataGrafik.map(item => item.nama_batch))];
        const bidangNames = [...new Set(rawDataGrafik.map(item => item.nama_bidang))];

        const datasetsGrafik = bidangNames.map(bidang => {
            const data = labelsGrafik.map(batch => {
                const entry = rawDataGrafik.find(item => item.nama_batch === batch && item.nama_bidang === bidang);
                return entry ? entry.jml_paket : 0; // Jika tidak ada, set ke 0
            });

            return {
                label: bidang,
                data: data,
                backgroundColor: getColor(bidang), // Get color based on bidang
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
    function getColor(bidang) {
        switch (bidang) {
            case 'Sumber Daya Air': return 'rgba(54, 162, 235, 1)';
            case 'Bina Marga': return 'rgba(255, 99, 132, 1)';
            case 'Cipta Karya': return 'rgba(255, 206, 86, 1)';
            case 'Perumahan': return 'rgba(209, 155, 113, 0.5)';
            default: return 'rgba(153, 102, 255, 1)';
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
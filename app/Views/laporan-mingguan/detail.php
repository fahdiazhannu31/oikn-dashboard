<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-4 fw-semibold">
                <i class="fi fi-tr-folder-open me-2 text-primary"></i>
                Detail Laporan Mingguan
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Nama Bulan</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporanMingguanDetail)): ?>
                            <?php foreach ($laporanMingguanDetail as $i => $laporan): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <i class="fi fi-tr-folder text-secondary me-2"></i>
                                        <?= esc($laporan->nama_bulan) ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('laporan-mingguan/detail/' . esc($laporan->id)) ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fi fi-tr-eye me-1"></i>
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Data detail laporan tidak tersedia
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

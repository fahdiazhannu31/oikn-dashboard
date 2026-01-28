<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Progress::pelaksanaanProgress');
    $routes->get('progress/pelaksanaan', 'Progress::pelaksanaanProgress');
    $routes->get('progress/perencanaan', 'Progress::perencanaanProgress');
    $routes->get('progress/pengadaan', 'Progress::pengadaanBrgJS');
    $routes->get('progress/ded', 'Progress::dedProgress');
    $routes->get('video-progress', 'Progress::videoProgress');
    $routes->get('resume/clash-detection', 'Progress::clashDetection');
    $routes->get('resume/smkk', 'Progress::smkk');
    $routes->get('resume/pengadaan-tanah/(:any)', 'Progress::pengadaanTanah/$1');
    $routes->get('resume/data/(:any)', 'Progress::dataPekerjaMenu/$1');
    $routes->get('progress/api/data-grafik', 'Progress::dataGrafikPkt');
    $routes->get('progress/api/data-fisik', 'Progress::dataGrafikFisik');
    $routes->get('progress/api/data-perencanaan', 'Progress::dataGrafikPrc');
    $routes->get('progress/api/data-onsel', 'Progress::dataGrafikOnsel');
    $routes->get('progress/api/data-ded', 'Progress::dataGrafikDed');
    $routes->get('progress/api/data-pekerja-core', 'Progress::dataPekerjaCore');
    $routes->get('progress/api/data-clash', 'Progress::dataClash');
    $routes->post('progress/data-masalah-percepatan', 'Progress::dataMasalahPercepatan');

    $routes->post('storePelaksanaan', 'Admin::storePelaksanaan');
    $routes->post('storeResumePelaksanaan', 'Admin::storeResumePelaksanaan');
    $routes->get('detailPelaksanaan', 'Admin::detailPelaksanaan');
    $routes->post('updatePelaksanaan', 'Admin::updatePelaksanaan');
    $routes->get('detailResumePelaksanaan/(:any)', 'Admin::detailResumePelaksanaan/$1');
    $routes->post('updateResumePelaksanaan', 'Admin::updateResumePelaksanaan');
    $routes->post('deleteResumePelaksanaan', 'Admin::deleteResumePelaksanaan');

    $routes->post('storeRenrel', 'Admin::storeRenrel');
    $routes->post('storeOnsel', 'Admin::storeOnsel');
    $routes->post('deleteRenOnsel', 'Admin::deleteRenOnsel');
    $routes->post('updateRenrelChart', 'Admin::updateRenrelChart');
    $routes->post('updateOnselChart', 'Admin::updateOnselChart');
    $routes->post('storePerencanaan', 'Admin::storePerencanaan');
    $routes->get('detailPerencanaan', 'Admin::detailPerencanaan');
    $routes->post('updatePerencanaan', 'Admin::updatePerencanaan');


    $routes->post('storeDataClashDetection', 'Admin::storeDataClashDetection');
    $routes->get('detailClashDetection', 'Admin::detailClashDetection');
    $routes->post('updateClashDetection', 'Admin::updateClashDetection');

    $routes->post('storePengadaanTanah', 'Admin::storePengadaanTanah');
    $routes->get('detailPengadaanTnh', 'Admin::detailPengadaanTnh');
    $routes->post('updatePengadaanTanah', 'Admin::updatePengadaanTanah');

    $routes->post('storePaketPengadaan', 'Admin::storePengadaanPaket');
    $routes->get('detailPaketTanah', 'Admin::detailPaketTanah');
    $routes->post('updateDataPaket', 'Admin::updateDataPaket');


    $routes->post('storeMasalahPercepatan', 'Admin::storeMasalahPercepatan');
    $routes->get('detailMasalahPercepatan', 'Admin::detailMasalahPercepatan');
    $routes->post('updateDataPaket', 'Admin::updateDataPaket');

    $routes->get('detailDokSMKK', 'Admin::detailDokSMKK');
    $routes->post('updateDokumen', 'Admin::updateDokumen');
    $routes->post('storeSMKKDokumen', 'Admin::storeSMKKDokumen');
    $routes->get('detailSMKKDash', 'Admin::detailSMKKDash');
    $routes->post('updateDash', 'Admin::updateDash');
    $routes->post('storeSMKKDashboard', 'Admin::storeSMKKDashboard');

    $routes->post('storeDataPekerja', 'Admin::storeDataPekerja');
    $routes->get('detailDataPekerja/(:any)', 'Admin::detailDataPekerja/$1');
    $routes->post('updateDetailPekerja', 'Admin::updateDetailPekerja');
    $routes->post('deleteDataPekerja', 'Admin::deleteDataPekerja');

    $routes->get('detailDataFisik', 'Admin::detailDataFisik');
    $routes->post('updateDataFisik', 'Admin::updateDataFisik');
    $routes->post('storeResumeFisik', 'Admin::storeResumeFisik');

    $routes->get('detailDataBidang', 'Admin::detailBidang');
    $routes->post('updateBidang', 'Admin::updateBidang');
    $routes->post('storeResumeBidang', 'Admin::storeResumeBidang');

    $routes->get('detailDataVideo', 'Admin::detailVideo');
    $routes->post('updateVideo', 'Admin::updateVideo');
    $routes->post('storeVideo', 'Admin::storeVideo');
    $routes->post('deleteVideo', 'Admin::deleteVideo');


    $routes->get('monitoring-dcr', 'Progress::monitoringDcr');
    $routes->get('laporan-mingguan', 'Laporan::laporanMingguan');
    $routes->get('laporan-mingguan/detail/(:any)', 'Laporan::detailLaporanMingguan/$1');
});

// Authentication routes (no filter)
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Myth\Auth\Controllers\Auth::login');
    $routes->post('login', 'Myth\Auth\Controllers\Auth::login');
    $routes->get('register', 'Myth\Auth\Controllers\Auth::register');
    $routes->post('register', 'Myth\Auth\Controllers\Auth::register');
    $routes->get('logout', 'Myth\Auth\Controllers\Auth::logout'); // Logout route
});

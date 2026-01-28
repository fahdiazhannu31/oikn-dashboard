<?php

namespace App\Controllers;

use App\Models\DataPekerjaModel;
use App\Models\LaporanModel;
use App\Models\PengadaanModel;


class Laporan extends BaseController
{

    protected $laporanModel;
    protected $pengadaanModel;
    protected $dataPekerjaModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->pengadaanModel = new PengadaanModel();
        $this->dataPekerjaModel = new DataPekerjaModel();
    }
    public function laporanMingguan()
    {
        $data['title'] = 'Laporan Mingguan';
        $data['menu'] = $this->pengadaanModel->getJenisPengadaan();
        $data['datapekerja'] = $this->dataPekerjaModel->getDataPekerjaMenu();
        $data['laporanMingguan'] = $this->laporanModel->getLaporanMingguan();
        // Pass data folder dan file ke view
        return view('laporan-mingguan/index', $data);
    }
    public function detailLaporanMingguan($id)
    {
        $data['title'] = 'Laporan Mingguan';
        $data['menu'] = $this->pengadaanModel->getJenisPengadaan();
        $data['datapekerja'] = $this->dataPekerjaModel->getDataPekerjaMenu();
        $data['laporanMingguan'] = $this->laporanModel->getLaporanMingguanById($id);
        // Pass data folder dan file ke view
        return view('laporan-mingguan/detail', $data);
    }
}

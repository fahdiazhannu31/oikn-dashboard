<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PelaksanaanModel;
use App\Models\PerencanaanModel;
use App\Models\ProgressModel;
use App\Models\PengadaanModel;
use App\Models\SMKKModel;
use App\Models\DataPekerjaModel;
use App\Models\BatchModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;

class Progress extends BaseController
{
    use ResponseTrait;
    protected $db;
    protected $jmlPaketModel;
    protected $pelaksanaanModel;
    protected $perencanaanModel;
    protected $progressModel;
    protected $batchModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pelaksanaanModel = new pelaksanaanModel();
        $this->perencanaanModel = new perencanaanModel();
        $this->progressModel = new progressModel();
        $this->batchModel = new batchModel();
    }
   public function pelaksanaanProgress()
{
    $data['title'] = 'Pelaksanaan';

    $pelaksanaanModel = new PelaksanaanModel();
    $pengadaanModel   = new PengadaanModel();
    $dataPekerjaModel = new DataPekerjaModel();
    $batchModel       = new BatchModel();

    $data['menu'] = $pengadaanModel->getJenisPengadaan();
    $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();

    $selectedDate = $this->request->getVar('tgl_upd');

    // 👉 JIKA TIDAK ADA TANGGAL / 00 → AMBIL TANGGAL TERAKHIR
    if (!$selectedDate || $selectedDate === '00') {
        $lastDate = $pelaksanaanModel->getLastTglUpd();
        $selectedDate = $lastDate ? $lastDate['tgl_upd'] : null;
    }

    // 👉 JIKA TANGGAL ADA
    if ($selectedDate) {
        $data['pelaksanaan'] = $pelaksanaanModel->getPelaksanaanProgressByDate($selectedDate);
        $data['total']       = $pelaksanaanModel->getPelaksanaanTotalByDate($selectedDate);
        $data['grafik']      = $pelaksanaanModel->getJmlPaketByDate($selectedDate);
        $data['fisik']       = $pelaksanaanModel->getJmlFisikByDate($selectedDate);
        $data['resume']      = $pelaksanaanModel->getResumeDataByDate($selectedDate);
    } else {
        // fallback kalau data kosong semua
        $data['pelaksanaan'] = [];
        $data['total'] = [];
        $data['grafik'] = [];
        $data['fisik'] = [];
        $data['resume'] = [];
    }

    // Data pendukung
    $data['progress_perfisik'] = $pelaksanaanModel->getPerFisik();
    $data['datapekerja']       = $dataPekerjaModel->getDataPekerjaMenu();
    $data['tgl_upd']           = [$selectedDate]; // agar status tampil konsisten
    $data['batch']             = $batchModel->getBatch();
    $data['option_waktu']      = $pelaksanaanModel->option_waktu_pelaksanaan();

    return view('pelaksanaan/index', $data);
}


   public function perencanaanProgress()
{
    $data['title'] = 'Perencanaan';

    $perencanaanModel = new PerencanaanModel();
    $pengadaanModel   = new PengadaanModel();
    $dataPekerjaModel = new DataPekerjaModel();
    $batchModel       = new BatchModel();

    $data['menu'] = $pengadaanModel->getJenisPengadaan();
    $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();

    $selectedDate = $this->request->getVar('tgl_upd');

    // 👉 JIKA TIDAK ADA TANGGAL / 00 → AMBIL TANGGAL TERAKHIR
    if (!$selectedDate || $selectedDate === '00') {
        $lastDate = $perencanaanModel->getLastTglUpd();
        $selectedDate = $lastDate ? $lastDate['tgl_upd'] : null;
    }

    // 👉 JIKA TANGGAL ADA
    if ($selectedDate) {
        $data['perencanaan']     = $perencanaanModel->getPerencanaanProgressByDate($selectedDate);
        $data['total']           = $perencanaanModel->getPerencanaanTotalByDate($selectedDate);
        $data['dataPerencanaan'] = $perencanaanModel->getJmlRenrelByDate($selectedDate);
        $data['dataOnsel']       = $perencanaanModel->getJmlOnSelByDate($selectedDate);
    } else {
        // fallback kalau data kosong
        $data['perencanaan'] = [];
        $data['total'] = [];
        $data['dataPerencanaan'] = [];
        $data['dataOnsel'] = [];
    }

    // Data pendukung
    $data['datapekerja']  = $dataPekerjaModel->getDataPekerjaMenu();
    $data['tgl_upd']      = [$selectedDate]; // 🔥 SAMA seperti pelaksanaan
    $data['option_waktu'] = $perencanaanModel->option_waktu_perencanaan();
    $data['batch']        = $batchModel->getBatch();

    return view('perencanaan/index', $data);
}


    public function pengadaanBrgJS()
    {
        $data['title'] = 'Pengadaan Barang Jasa';
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();
        $data['pengadaan'] = $pengadaanModel->getPengadaan(); // Memanggil metode di model
        $data['total'] = $pengadaanModel->getPerencanaanTotal();
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        return view('pengadaan/index', $data);
    }


    public function dedProgress()
    {
        $data['title'] = 'Progress DED';
        $progressModel = new ProgressModel();
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();
        $data['resume'] = $progressModel->getResumeDEDData();
        $data['ded'] = $progressModel->getDedProgress(); // Memanggil metode di model
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        return view('ded/index', $data);
    }

    public function clashDetection()
    {
        // Load necessary models
        $dataPekerjaModel = new DataPekerjaModel();
        $progressModel = new ProgressModel();
        $pengadaanModel = new PengadaanModel();

        // Load the database
        $db = \Config\Database::connect();

        // Initialize $data['clash_detection']
        $selectedDate = $this->request->getVar('tgl_upd');
        if ($selectedDate && $selectedDate !== '00') {
            $clash_detection = $progressModel->getClashDetectionDatabyDate($selectedDate);
            // Fetch records based on selected date
            $resumeData = $db->table('clash_detection')
                ->select('*')
                ->where('tgl_progress', $selectedDate)
                ->orderBy('tgl_progress', 'DESC')
                ->get()
                ->getResult();
        } else {
            $clash_detection = $progressModel->getClashDetectionData();
            // Fetch all records if no date is selected
            $resumeData = $db->table('clash_detection')
                ->select('*')
                ->orderBy('tgl_progress', 'DESC')
                ->get()
                ->getResult();
        }

        // Process the data to group by month
        $groupedData = [];
        foreach ($resumeData as $record) {
            $month = date('F', strtotime($record->tgl_progress)); // Get the month name
            $day = date('j', strtotime($record->tgl_progress));   // Get the day of the month

            // Organize the data by month and day
            $groupedData[$month][] = [
                'id' => $record->id,
                'day' => $day,
                'closed' => $record->close, // Replace 'closed' with the actual field from your database
                'open' => $record->open      // Replace 'open' with the actual field from your database
            ];
        }


        if ($selectedDate && $selectedDate !== '00') {
            $clash_detection = $progressModel->getClashDetectionDatabyDate($selectedDate);
            // Fetch records based on selected date
            $resumeData = $db->table('clash_detection')
                ->select('*')
                ->where('tgl_progress', $selectedDate)
                ->orderBy('tgl_progress', 'DESC')
                ->get()
                ->getResult();
        } else {
            $clash_detection = $progressModel->getClashDetectionData();
            // Fetch all records if no date is selected
            $resumeData = $db->table('clash_detection')
                ->select('*')
                ->orderBy('tgl_progress', 'DESC')
                ->get()
                ->getResult();
        }

        // Assign other data to be passed to the view
        $data = [
            'title' => 'Resume Clash Detection',
            'menu' => $pengadaanModel->getJenisPengadaan(),
            'jenis_pengadaan' => $pengadaanModel->getJenisPengadaan(),
            'resume' => $progressModel->getResumeDEDData(),
            'ded' => $progressModel->getDedProgress(),
            'datapekerja' => $dataPekerjaModel->getDataPekerjaMenu(),
            'clash_detection' => $clash_detection, // Pass clash_detection data
            'groupedData' => $groupedData,         // Add grouped data
            'option_waktu' => $progressModel->option_waktu_clash()
        ];

        // Fetch the last updated data from the clash_detection table
        $data['last_upd_data'] = $db->table('clash_detection')
            ->select('*')
            ->orderBy('tgl_progress', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();

        // Pass all data to the view
        return view('clash-detection/index', $data);
    }



    public function pengadaanTanah($slug)
    {
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();

        $selectedDate = $this->request->getVar('tgl_upd');
        if ($selectedDate && $selectedDate !== '00') {
            $jenisPengadaan = $pengadaanModel->getJenisPengadaanTanahbyDate($selectedDate, $slug);
            $tanahData = $pengadaanModel->getTanahDatabyDate($selectedDate, $slug);
            $masalahPercepatan = $pengadaanModel->getPercepatanMasalahbyDate($selectedDate, $slug);
        } else {
            $jenisPengadaan = $pengadaanModel->getJenisPengadaanTanah($slug);
            $tanahData = $pengadaanModel->getTanahData($slug);
            $masalahPercepatan = $pengadaanModel->getPercepatanMasalah($slug);
        }
        // Initialize the data array with all the required elements
        $data = [
            'title' => 'Pengadaan Tanah',
            'slug' => $slug,
            'menu' => $pengadaanModel->getJenisPengadaan(),
            'jenis_pengadaan' => $jenisPengadaan,
            'tanah_data' => $tanahData,
            'masalah_percepatan' => $masalahPercepatan,
            'last_upd_data' => $this->db->table('jenis_pengadaan_tanah a')
                ->select('*')
                ->join('jenis_pengadaan_main b', 'a.jenis_main_id = b.id')
                ->where('b.slug', $slug)
                ->orderBy('tgl_upd', 'DESC')
                ->limit(1)
                ->get()
                ->getResult(),
            'ditjen' => $pengadaanModel->getDitjen(),
            'datapekerja' => $dataPekerjaModel->getDataPekerjaMenu(),
            'option_waktu' => $pengadaanModel->option_waktu_pengadaan($slug)
        ];

        // Pass all data to the view
        return view('pengadaan-tanah/index', $data);
    }


    public function dataGrafikPkt()
    {
        $data = $this->pelaksanaanModel->getJmlPaket();

        return $this->response->setJSON($data);
    }
    public function dataGrafikFisik()
    {
        $data = $this->pelaksanaanModel->getJmlFisik();

        return $this->response->setJSON($data);
    }

    public function dataGrafikPrc()
    {
        $data = $this->perencanaanModel->getJmlRenrel();
        return $this->response->setJSON($data);
    }

    public function dataGrafikOnsel()
    {
        $data = $this->perencanaanModel->getJmlOnSel();
        return $this->response->setJSON($data);
    }

    public function dataGrafikDed()
    {
        $data = $this->progressModel->getDedProgress();

        return $this->response->setJSON($data);
    }

    public function dataClash()
    {
        $data = $this->progressModel->getClashDetectionData();
        return $this->response->setJSON($data);
    }

    public function dataMasalahPercepatan()
    {
        $requestData = $this->request->getPost();
        $slug = $this->request->getUri()->getSegment(3);

        // Debug the slug
        log_message('debug', 'Slug: ' . $slug);

        // Base query
        $builder = $this->db->table('masalah_percepatan a')
            ->select('a.nama_paket, a.status, a.kendala, a.tindak_lanjut')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->where('b.slug', $slug);

        // Apply search filter if search value is provided
        if (!empty($requestData['search']['value'])) {
            $searchValue = $requestData['search']['value'];
            $builder->groupStart()
                ->like('a.nama_paket', $searchValue)
                ->orLike('a.status', $searchValue)
                ->orLike('a.kendala', $searchValue)
                ->orLike('a.tindak_lanjut', $searchValue)
                ->groupEnd();
        }

        // Sorting
        if (isset($requestData['order']) && is_array($requestData['order']) && count($requestData['order']) > 0) {
            $columnIndex = $requestData['order'][0]['column'];
            $columnSortOrder = $requestData['order'][0]['dir'];

            $columnMap = [
                0 => 'a.nama_paket',
                1 => 'a.status',
                2 => 'a.kendala',
                3 => 'a.tindak_lanjut',
            ];

            if (array_key_exists($columnIndex, $columnMap)) {
                $builder->orderBy($columnMap[$columnIndex], $columnSortOrder);
            }
        }

        $builder->orderBy('a.id', 'DESC');

        // Log the SQL query
        $sql = $builder->getCompiledSelect();
        log_message('debug', 'SQL Query: ' . $sql);

        $totalRecords = $builder->countAllResults(false); // Count all records without pagination
        log_message('debug', 'Total Records: ' . $totalRecords);

        $builder->limit($requestData['length'], $requestData['start']);
        $list = $builder->get()->getResult();

        $data = [];
        foreach ($list as $r) {
            $data[] = [
                esc($r->nama_paket),
                esc($r->status),
                esc($r->kendala),
                esc(
                    $r->tindak_lanjut
                )
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($requestData['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

    public function smkk()
    {
        $pengadaanModel = new PengadaanModel();
        $smkkModel = new SMKKModel();
        $dataPekerjaModel = new DataPekerjaModel();

        // Inisialisasi array data
        $data = [
            'title' => 'Resume Penerapan SMKK',
            'menu' => $pengadaanModel->getJenisPengadaan(),
            'catatan' => $smkkModel->getCatatanSmkk(),
            'datapekerja' => $dataPekerjaModel->getDataPekerjaMenu(),
            'jenis_smkk' => $smkkModel->getJenisSmkk(),
            'last_upd_data' => $this->db->table('smkk_dashboard')
                ->select('*')
                ->orderBy('tgl_upd', 'DESC')
                ->limit(1)
                ->get()
                ->getResult(),
            'option_waktu' => $smkkModel->option_waktu_smkk(),
        ];

        // Mendapatkan tanggal yang dipilih dari request
        $selectedDate = $this->request->getVar('tgl_upd');
        if ($selectedDate && $selectedDate !== '00') {
            $data['dokumen'] = $smkkModel->getDokumenSmkkbyDate($selectedDate);
            $data['dashboard'] = $smkkModel->getDashboardSmkkbyDate($selectedDate);
        } else {
            $data['dokumen'] = $smkkModel->getDokumenSmkk();
            $data['dashboard'] = $smkkModel->getDashboardSmkk();
        }

        // Mengembalikan data ke view
        return view('smkk/index', $data);
    }


    public function dataPekerjaMenu($slug)
    {
        $dataPekerjaModel = new DataPekerjaModel();
        $pengadaanModel = new PengadaanModel();
        $data['title'] = 'Data Pekerja';
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['chart_data'] = $dataPekerjaModel->getDataPekerjaChart($slug);
        $data['data_pekerja'] = $this->db->table('data_pekerja')
            ->select('*')
            ->get()
            ->getResult();
        $data['data_pekerja_detail'] = $this->db->table('data_pekerja_detail a')
            ->select('a.id, a.no_index_paket, a.unor, a.nama_paket, a.nama_kontraktor, a.lokal, a.luar, a.total_tenaga_kerja')
            ->join('data_pekerja b', 'a.data_pekerja_id = b.id')
            ->where('b.slug', $slug)
            ->get()
            ->getResult();
        $data['last_upd_data'] = $this->db->table('data_pekerja_detail')
            ->select('*')
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();

        return view('data-pekerja/index', $data);
    }

    public function videoProgress()
    {
        $dataPekerjaModel = new DataPekerjaModel();
        $pengadaanModel = new PengadaanModel();
        $data['title'] = 'Video Progress';
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['video'] = $this->db->table('video_progress')->select('*')->get()->getResult();
        return view('video-progress/index', $data);
    }

    public function monitoringDcr()
    {
        $dataPekerjaModel = new DataPekerjaModel();
        $pengadaanModel = new PengadaanModel();
        $data['title'] = 'Monitoring DCR';
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        return view('monitoring-dcr/index', $data);
    }

}

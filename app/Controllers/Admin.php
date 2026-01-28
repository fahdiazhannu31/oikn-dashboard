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
use App\Models\ResumePelaksanaanModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;


class Admin extends BaseController
{
    use ResponseTrait;
    protected $db;
    protected $jmlPaketModel;
    protected $pelaksanaanModel;
    protected $perencanaanModel;
    protected $progressModel;
    protected $pekerjaModel;
    protected $resumepelaksanaanModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pelaksanaanModel = new pelaksanaanModel();
        $this->perencanaanModel = new perencanaanModel();
        $this->progressModel = new progressModel();
        $this->pekerjaModel = new DataPekerjaModel();
        $this->resumepelaksanaanModel = new ResumePelaksanaanModel();
    }


    public function storePelaksanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ket_1' => $post['ket_1'],
            'ket_2' => $post['ket_2'],
            'ket_3' => $post['ket_3'],
            'jml_paket' => $post['jml_paket'],
            'total_pagu' => $post['total_pagu'],
            'progress_fisik' => $post['progress_fisik'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('pelaksanaan')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function storeResumePelaksanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'unor' => $post['unor'],
            'nama_paket' => $post['nama_paket'],
            'rencana' => $post['rencana'],
            'realisasi' => $post['realisasi'],
            'deviasi' => $post['deviasi'],
            'status' => $post['status'],
            'isu' => $post['isu'],
            'tgl_data' => $post['tgl_data'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('resume_pelaksanaan')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function updatePelaksanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ket_1' => $post['ket_1'],
            'ket_2' => $post['ket_2'],
            'ket_3' => $post['ket_3'],
            'jml_paket' => $post['jml_paket'],
            'total_pagu' => $post['total_pagu'],
            'progress_fisik' => $post['progress_fisik'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('pelaksanaan')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function detailPelaksanaan()
    {

        $query = $this->db->table('pelaksanaan')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "batch_id" => esc($query->getRow()->batch_id),
            "ket_1" => esc($query->getRow()->ket_1),
            "ket_2" => esc($query->getRow()->ket_2),
            "ket_3" => esc($query->getRow()->ket_3),
            "jml_paket" => esc($query->getRow()->jml_paket),
            "total_pagu" => esc($query->getRow()->total_pagu),
            "progress_fisik" => esc($query->getRow()->progress_fisik),
            "tgl_upd" => esc($query->getRow()->tgl_upd),
        );
        echo '[' . json_encode($result) . ']';
    }


    public function detailResumePelaksanaan($id)
    {
        $data = $this->resumepelaksanaanModel->find($id); // Temukan data pekerja berdasarkan ID
        return $this->response->setJSON($data); // Kembalikan data dalam format JSON
    }

    public function deleteResumePelaksanaan()
    {

        // Delete the data by ID
        if ($this->resumepelaksanaanModel->delete($this->request->getPost('id'))) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }


    public function detailPerencanaan()
    {

        $query = $this->db->table('perencanaan')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "batch_id" => esc($query->getRow()->batch_id),
            "ket_1" => esc($query->getRow()->ket_1),
            "ket_2" => esc($query->getRow()->ket_2),
            "jml_paket" => esc($query->getRow()->jml_paket),
            "progress_perencanaan" => esc($query->getRow()->progress_perencanaan),
            "tgl_upd" => esc($query->getRow()->tgl_upd),
        );
        echo '[' . json_encode($result) . ']';
    }


    public function storePerencanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ket_1' => $post['ket_1'],
            'ket_2' => $post['ket_2'],
            'jml_paket' => $post['jml_paket'],
            'progress_perencanaan' => $post['progress_perencanaan'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('perencanaan')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function updatePerencanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ket_1' => $post['ket_1'],
            'ket_2' => $post['ket_2'],
            'jml_paket' => $post['jml_paket'],
            'progress_perencanaan' => $post['progress_perencanaan'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'perencanaan' table
        $insert = $this->db->table('perencanaan')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function updatePaket()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ket_1' => $post['ket_1'],
            'ket_2' => $post['ket_2'],
            'jml_paket' => $post['jml_paket'],
            'progress_perencanaan' => $post['progress_perencanaan'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'perencanaan' table
        $insert = $this->db->table('pengadaan_tanah')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function pelaksanaanProgress()
    {
        $data['title'] = 'Pelaksanaan';
        $pelaksanaanModel = new PelaksanaanModel(); // Inisialisasi model
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();
        $data['pelaksanaan'] = $pelaksanaanModel->getPelaksanaanProgress(); // Memanggil metode di model
        $data['total'] = $pelaksanaanModel->getPelaksanaanTotal();
        $data['grafik'] = $pelaksanaanModel->getJmlPaket();
        $data['resume'] = $pelaksanaanModel->getResumeData();
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['tgl_upd'] = $pelaksanaanModel->getTglUpd();
        return view('pelaksanaan/index', $data); // Mengirim data ke view
    }

    public function perencanaanProgress()
    {
        $data['title'] = 'Perencanaan';
        $perencanaanModel = new PerencanaanModel();
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaan();
        $data['perencanaan'] = $perencanaanModel->getPerencanaanProgress(); // Memanggil metode di model
        $data['total'] = $perencanaanModel->getPerencanaanTotal();
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['tgl_upd'] = $perencanaanModel->getTglUpd();
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

        // Assign data to be passed to the view
        $data = [
            'title' => 'Resume Clash Detection',
            'menu' => $pengadaanModel->getJenisPengadaan(),
            'jenis_pengadaan' => $pengadaanModel->getJenisPengadaan(),
            'resume' => $progressModel->getResumeDEDData(),
            'ded' => $progressModel->getDedProgress(),
            'datapekerja' => $dataPekerjaModel->getDataPekerjaMenu(),
        ];

        // Load the database
        $db = \Config\Database::connect();
        // Fetch the last updated data from the clash_detection table
        $data['last_upd_data'] = $db->table('clash_detection')
            ->select('*')
            ->orderBy('tgl_progress', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();

        // Fetch all records from the clash_detection table
        $resumeData = $db->table('clash_detection')
            ->select('*')
            ->orderBy('tgl_progress', 'DESC')
            ->get()
            ->getResult();

        // Process the data to group by month
        $groupedData = [];
        foreach ($resumeData as $record) {
            $month = date('F', strtotime($record->tgl_progress)); // Get the month name (e.g., 'March')
            $day = date('j', strtotime($record->tgl_progress)); // Get the day of the month (e.g., '21')

            // Organize the data by month and day
            $groupedData[$month][] = [
                'day' => $day,
                'closed' => $record->close, // Replace 'closed' with the actual field from your database
                'open' => $record->open      // Replace 'open' with the actual field from your database
            ];
        }

        // Add the grouped data to the data array to be passed to the view
        $data['groupedData'] = $groupedData;
        // Pass all the data to the view
        return view('clash-detection/index', $data);
    }


    public function pengadaanTanah($slug)
    {
        $pengadaanModel = new PengadaanModel();
        $dataPekerjaModel = new DataPekerjaModel();
        $data['title'] = 'Pengadaan Tanah';
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['jenis_pengadaan'] = $pengadaanModel->getJenisPengadaanTanah($slug);
        $data['tanah_data'] = $this->db->table('pengadaan_tanah a')
            ->select('*')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->where('b.slug', $slug)
            ->get()
            ->getResult();
        $data['masalah_percepatan'] = $this->db->table('masalah_percepatan a')
            ->select('*')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->where('b.slug', $slug)
            ->get()
            ->getResult();
        $data['last_upd_data'] = $this->db->table('jenis_pengadaan_tanah')
            ->select('*')
            ->where('slug', $slug)
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
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
        $data['title'] = 'Resume Penerapan SMKK';
        $data['menu'] = $pengadaanModel->getJenisPengadaan();
        $data['dokumen'] = $smkkModel->getDokumenSmkk();
        $data['dashboard'] = $smkkModel->getDashboardSmkk();
        $data['catatan'] = $smkkModel->getCatatanSmkk();
        $data['datapekerja'] = $dataPekerjaModel->getDataPekerjaMenu();
        $data['last_upd_data'] = $this->db->table('jenis_smkk')
            ->select('*')
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
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
        $data['data_pekerja'] = $this->db->table('data_pekerja_detail a')
            ->select('*')
            ->join('data_pekerja b', 'a.data_pekerja_id = b.id')
            ->where('b.slug', $slug)
            ->get()
            ->getResult();
        $data['data_pekerja_detail'] = $this->db->table('data_pekerja_detail a')
            ->select('*')
            ->join('data_pekerja b', 'a.data_pekerja_id = b.id')
            ->where('b.slug', $slug)
            ->get()
            ->getResult();
        $data['last_upd_data'] = $this->db->table('data_pekerja_detail')
            ->select('*')
            ->orderBy('tgl_upd', 'DESC')
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


    public function storeDataClashDetection()
    {
        $post = $this->request->getPost();
        $data = [
            'tgl_progress' => $post['tgl_progress'],
            'open' => $post['open'],
            'close' => $post['close'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('clash_detection')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function detailClashDetection()
    {

        $query = $this->db->table('clash_detection')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "tgl_progress" => $query->getRow()->tgl_progress,
            "open" => esc($query->getRow()->open),
            "close" => esc($query->getRow()->close),
        );
        echo '[' . json_encode($result) . ']';
    }

    public function updateClashDetection()
    {
        $post = $this->request->getPost();
        $data = [
            'tgl_progress' => $post['tgl_progress'],
            'open' => $post['open'],
            'close' => $post['close'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('clash_detection')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailPengadaanTnh()
    {

        $query = $this->db->table('jenis_pengadaan_tanah')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "tgl_upd" => $query->getRow()->tgl_upd,
            "total_kebutuhan_lahan" => $query->getRow()->total_kebutuhan_lahan,
            "total_lahan_sudah_bebas" => $query->getRow()->total_lahan_sudah_bebas,
            "total_lahan_belum_bebas" => $query->getRow()->total_lahan_belum_bebas,
            "total_lahan_belum_bebas_value" => $query->getRow()->total_lahan_belum_bebas_value,
            "total_lahan_bebas_value" => $query->getRow()->total_lahan_bebas_value,
        );
        echo '[' . json_encode($result) . ']';
    }


    public function storePengadaanTanah()
    {
        $post = $this->request->getPost();
        $data = [
            'jenis_main_id' => $post['jenis_main_id'],
            'tgl_upd' => $post['tgl_upd'],
            'total_kebutuhan_lahan' => $post['total_kebutuhan_lahan'],
            'total_lahan_sudah_bebas' => $post['total_lahan_sudah_bebas'],
            'total_lahan_belum_bebas' => $post['total_lahan_belum_bebas'],
            'total_lahan_belum_bebas_value' => $post['total_lahan_belum_bebas_value'],
            'total_lahan_bebas_value' => $post['total_lahan_bebas_value'],

        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('jenis_pengadaan_tanah')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function storePengadaanPaket()
    {
        $post = $this->request->getPost();
        $data = [
            'jenis_pengadaan_tanah_id' => $post['jenis_pengadaan_tanah_id'],
            'nama_paket' => $post['nama_paket'],
            'kebutuhan_lahan' => $post['kebutuhan_lahan'],
            'kebutuhan_lahan_value' => $post['kebutuhan_lahan_value'],
            'sdh_bbs' => $post['sdh_bbs'],
            'sdh_bbs_value' => $post['sdh_bbs_value'],
            'blm_bebas' => $post['blm_bebas'],
            'blm_bebas_value' => $post['blm_bebas_value'],
            'siap_byr' => $post['siap_byr'],
            'siap_bayar_value' => $post['siap_bayar_value'],
            'konsinyasi' => $post['konsinyasi'],
            'konsinyasi_value' => $post['konsinyasi_value'],
            'phk_undang' => $post['phk_undang'],
            'phk_undang_value' => $post['phk_undang_value'],
            'proses_penilaian_kjpp' => $post['proses_penilaian_kjpp'],
            'proses_penilaian_kjpp_value' => $post['proses_penilaian_kjpp_value'],
            'sdh_pengumuman' => $post['sdh_pengumuman'],
            'sdh_pengumuman_value' => $post['sdh_pengumuman_value'],
            'blm_pengumuman' => $post['blm_pengumuman'],
            'blm_pengumuman_value' => $post['blm_pengumuman_value'],
            'tanah_karakteristik' => $post['tanah_karakteristik'],
            'tanah_karakteristik_value' => $post['tanah_karakteristik_value'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'jenis_pengadaan_tanah' table
        $insert = $this->db->table('pengadaan_tanah')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, return a success message
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, return an error message
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function updatePengadaanTanah()
    {
        $post = $this->request->getPost();
        $data = [
            'tgl_upd' => $post['tgl_upd'],
            'total_kebutuhan_lahan' => $post['total_kebutuhan_lahan'],
            'total_lahan_sudah_bebas' => $post['total_lahan_sudah_bebas'],
            'total_lahan_belum_bebas' => $post['total_lahan_belum_bebas'],
            'total_lahan_belum_bebas_value' => $post['total_lahan_belum_bebas_value'],
            'total_lahan_bebas_value' => $post['total_lahan_bebas_value'],

        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('jenis_pengadaan_tanah')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailPaketTanah()
    {

        $query = $this->db->table('pengadaan_tanah')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "tgl_upd" => $query->getRow()->tgl_upd,
            "nama_paket" => $query->getRow()->nama_paket,
            "kebutuhan_lahan" => $query->getRow()->kebutuhan_lahan,
            "kebutuhan_lahan_value" => $query->getRow()->kebutuhan_lahan_value,
            "sdh_bbs" => $query->getRow()->sdh_bbs,
            "sdh_bbs_value" => $query->getRow()->sdh_bbs_value,
            "blm_bebas" => $query->getRow()->blm_bebas,
            "blm_bebas_value" => $query->getRow()->blm_bebas_value,
            "siap_byr" => $query->getRow()->siap_byr,
            "siap_bayar_value" => $query->getRow()->siap_bayar_value,
            "konsinyasi" => $query->getRow()->konsinyasi,
            "konsinyasi_value" => $query->getRow()->konsinyasi_value,
            "phk_undang" => $query->getRow()->phk_undang,
            "phk_undang_value" => $query->getRow()->phk_undang_value,
            "proses_penilaian_kjpp" => $query->getRow()->proses_penilaian_kjpp,
            "proses_penilaian_kjpp_value" => $query->getRow()->proses_penilaian_kjpp_value,
            "sdh_pengumuman" => $query->getRow()->sdh_pengumuman,
            "sdh_pengumuman_value" => $query->getRow()->sdh_pengumuman_value,
            "blm_pengumuman" => $query->getRow()->blm_pengumuman,
            "blm_pengumuman_value" => $query->getRow()->blm_pengumuman_value,
            "tanah_karakteristik" => $query->getRow()->tanah_karakteristik,
            "tanah_karakteristik_value" => $query->getRow()->tanah_karakteristik_value,
        );
        echo '[' . json_encode($result) . ']';
    }

    public function storeMasalahPercepatan()
    {
        $post = $this->request->getPost();
        $data = [
            'nama_paket' => $post['nama_paket'],
            'jenis_pengadaan_tanah_id' => $post['jenis_pengadaan_tanah_id'],
            'status' => $post['status'],
            'kendala' => $post['kendala'],
            'tindak_lanjut' => $post['tindak_lanjut'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('masalah_percepatan')->insert($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }
    public function detailMasalahPercepatan()
    {
        $query = $this->db->table('masalah_percepatan')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "nama_paket" => $query->getRow()->nama_paket,
            "status" => esc($query->getRow()->status),
            "kendala" => esc($query->getRow()->kendala),
            "tindak_lanjut" => esc($query->getRow()->tindak_lanjut),
        );
        echo '[' . json_encode($result) . ']';
    }


    public function detailDokSMKK()
    {
        $query = $this->db->table('smkk_dokumen')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "smkk_jenis_id" => $query->getRow()->smkk_jenis_id,
            "tertib" => esc($query->getRow()->tertib),
            "tidak_tertib" => esc($query->getRow()->tidak_tertib),
            "jml_kecelakaan" => esc($query->getRow()->jml_kecelakaan),
            "total_jam_kerja" => esc($query->getRow()->total_jam_kerja),
            "note" => $query->getRow()->note,
            "tgl_upd" => esc($query->getRow()->tgl_upd),
        );
        echo '[' . json_encode($result) . ']';
    }

    public function updateDokumen()
    {
        $post = $this->request->getPost();
        $data = [
            'smkk_jenis_id' => $post['smkk_jenis_id'],
            'tertib' => $post['tertib'],
            'tidak_tertib' => $post['tidak_tertib'],
            'jml_kecelakaan' => $post['jml_kecelakaan'],
            'total_jam_kerja' => $post['total_jam_kerja'],
            'note' => $post['note'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('smkk_dokumen')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function storeSMKKDokumen()
    {
        // Tentukan aturan validasi
        $validationRules = [
            'smkk_jenis_id' => 'required',
            'tertib' => 'required',
            'tidak_tertib' => 'required',
            'jml_kecelakaan' => 'required',
            'total_jam_kerja' => 'required',
            'note' => 'required',
            'tgl_upd' => 'required|valid_date',
        ];

        // Validasi input berdasarkan aturan
        if (!$this->validate($validationRules)) {
            // Jika validasi gagal, kirimkan error
            $errors = $this->validator->getErrors();
            return json_encode(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $errors]);
        }

        // Ambil data dari input POST setelah validasi sukses
        $post = $this->request->getPost();
        $data = [
            'smkk_jenis_id' => $post['smkk_jenis_id'],
            'tertib' => $post['tertib'],
            'tidak_tertib' => $post['tidak_tertib'],
            'jml_kecelakaan' => $post['jml_kecelakaan'],
            'total_jam_kerja' => $post['total_jam_kerja'],
            'note' => $post['note'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke dalam tabel 'smkk_dokumen'
        $insert = $this->db->table('smkk_dokumen')->insert($data);

        // Cek apakah data berhasil disimpan
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailSMKKDash()
    {

        $query = $this->db->table('smkk_dashboard')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "smkk_jenis_id" => $query->getRow()->smkk_jenis_id,
            "memuaskan" => $query->getRow()->memuaskan,
            "cukup" => $query->getRow()->cukup,
            "baik" => $query->getRow()->baik,
            "kurang" => $query->getRow()->kurang,
            "rata_nilai" => $query->getRow()->rata_nilai,
            "note" => $query->getRow()->note,
            "tgl_upd" => $query->getRow()->tgl_upd,
        );
        echo '[' . json_encode($result) . ']';
    }


    public function updateDash()
    {
        $post = $this->request->getPost();
        $data = [
            'smkk_jenis_id' => $post['smkk_jenis_id'],
            'memuaskan' => $post['memuaskan'],
            'baik' => $post['baik'],
            'cukup' => $post['cukup'],
            'rata_nilai' => $post['rata_nilai'],
            'note' => $post['note'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('smkk_dashboard')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeSMKKDashboard()
    {
        // Tentukan aturan validasi
        $validationRules = [
            'smkk_jenis_id' => 'required',
            'memuaskan' => 'required',
            'cukup' => 'required',
            'baik' => 'required',
            'kurang' => 'required',
            'rata_nilai' => 'required',
            'note' => 'required',
            'tgl_upd' => 'required|valid_date',
        ];

        // Validasi input berdasarkan aturan
        if (!$this->validate($validationRules)) {
            // Jika validasi gagal, kirimkan error
            $errors = $this->validator->getErrors();
            return json_encode(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $errors]);
        }

        // Ambil data dari input POST setelah validasi sukses
        $post = $this->request->getPost();
        $data = [
            'smkk_jenis_id' => $post['smkk_jenis_id'],
            'memuaskan' => $post['memuaskan'],
            'cukup' => $post['cukup'],
            'baik' => $post['baik'],
            'kurang' => $post['kurang'],
            'rata_nilai' => $post['rata_nilai'],
            'note' => $post['note'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke dalam tabel 'smkk_dokumen'
        $insert = $this->db->table('smkk_dashboard')->insert($data);

        // Cek apakah data berhasil disimpan
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function storeDataPekerja()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'data_pekerja_id' => $post['data_pekerja_id'],
            'no_index_paket' => $post['no_index_paket'],
            'unor' => $post['unor'],
            'nama_paket' => $post['nama_paket'],
            'nama_kontraktor' => $post['nama_kontraktor'],
            'lokal' => $post['lokal'],
            'luar' => $post['luar'],
            'total_tenaga_kerja' => $post['total_tenaga_kerja'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('data_pekerja_detail')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailDataPekerja($id)
    {
        $data = $this->pekerjaModel->find($id); // Temukan data pekerja berdasarkan ID
        return $this->response->setJSON($data); // Kembalikan data dalam format JSON
    }

    public function updateDetailPekerja()
    {
        $post = $this->request->getPost();
        $data = [
            'data_pekerja_id' => $post['data_pekerja_id'],
            'no_index_paket' => $post['no_index_paket'],
            'unor' => $post['unor'],
            'nama_paket' => $post['nama_paket'],
            'nama_kontraktor' => $post['nama_kontraktor'],
            'lokal' => $post['lokal'],
            'luar' => $post['luar'],
            'total_tenaga_kerja' => $post['total_tenaga_kerja'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('data_pekerja_detail')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function deleteDataPekerja()
    {

        // Delete the data by ID
        if ($this->pekerjaModel->delete($this->request->getPost('id'))) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }


    public function updateResumePelaksanaan()
    {
        $post = $this->request->getPost();
        $data = [
            'unor' => $post['unor'],
            'nama_paket' => $post['nama_paket'],
            'rencana' => $post['rencana'],
            'realisasi' => $post['realisasi'],
            'deviasi' => $post['deviasi'],
            'status' => $post['status'],
            'isu' => $post['isu'],
            'tgl_data' => $post['tgl_data'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('resume_pelaksanaan')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailDataFisik()
    {
        $query = $this->db->table('progress_fisik')->getWhere(array('id_fisik' => $this->request->getGet("id")), 1);
        $result = array(
            "batch_id" => $query->getRow()->batch_id,
            "fisik_progress_id" => $query->getRow()->fisik_progress_id,
            "jml_progress" => $query->getRow()->jml_progress,
            "tgl_upd" => $query->getRow()->tgl_upd,
        );
        echo '[' . json_encode($result) . ']';
    }

    public function updateDataFisik()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'fisik_progress_id' => $post['fisik_progress_id'],
            'jml_progress' => $post['jml_progress'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('progress_fisik')->where('id_fisik', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeResumeFisik()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'batch_id' => $post['batch_id'],
            'fisik_progress_id' => $post['fisik_progress_id'],
            'jml_progress' => $post['jml_progress'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('progress_fisik')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function detailBidang()
    {

        $query = $this->db->table('jml_pkt_bidang')->getWhere(array('id' => $this->request->getGet("id")), 1);

        $result = array(
            "bidang_id" => $query->getRow()->bidang_id,
            "batch_id" => $query->getRow()->batch_id,
            "jml_paket" => esc($query->getRow()->jml_paket),
            "tgl_upd" => esc($query->getRow()->tgl_upd),
        );
        echo '[' . json_encode($result) . ']';
    }


    public function updateBidang()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'bidang_id' => $post['bidang_id'],
            'jml_paket' => $post['jml_paket'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('jml_pkt_bidang')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeResumeBidang()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'batch_id' => $post['batch_id'],
            'bidang_id' => $post['bidang_id'],
            'jml_paket' => $post['jml_paket'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('jml_pkt_bidang')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeVideo()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'nama_video' => $post['nama_video'],
            'link_video' => $post['link_video'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('video_progress')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function detailVideo()
    {

        $query = $this->db->table('video_progress')->getWhere(array('id' => $this->request->getGet("id")), 1);
        $result = array(
            "nama_video" => $query->getRow()->nama_video,
            "link_video" => $query->getRow()->link_video,
            "tgl_upd" => esc($query->getRow()->tgl_upd),
        );
        echo '[' . json_encode($result) . ']';
    }

    public function updateVideo()
    {
        $post = $this->request->getPost();
        $data = [
            'nama_video' => $post['nama_video'],
            'link_video' => $post['link_video'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('video_progress')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function deleteVideo()
    {

        // Delete the data by ID
        if ($this->db->table('video_progress')->where('id', $this->request->getPost('id'))->delete()) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
public function updateRenrelChart()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'realisasi' => $post['realisasi'],
            'rencana' => $post['rencana'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('rencana_rendev')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function updateOnSelChart()
    {
        $post = $this->request->getPost();
        $data = [
            'batch_id' => $post['batch_id'],
            'ren_ongoing' => $post['ren_ongoing'],
            'ren_sel' => $post['ren_sel'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data into the 'pelaksanaan' table
        $insert = $this->db->table('rencana_rendev')->where('id', $post['id'])->update($data);

        // Check if the insert operation was successful
        if ($insert) {
            // If successful, do something (e.g., return a success message)
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            // If not successful, do something else (e.g., return an error message)
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeRenrel()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'batch_id' => $post['batch_id'],
            'realisasi' => $post['realisasi'],
            'rencana' => $post['rencana'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('rencana_rendev')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    public function storeOnsel()
    {
        $post = $this->request->getPost();
        // Ambil input dari request
        $data = [
            'batch_id' => $post['batch_id'],
            'ren_ongoing' => $post['ren_ongoing'],
            'ren_sel' => $post['ren_sel'],
            'tgl_upd' => $post['tgl_upd'],
        ];

        // Insert data ke database
        $insert = $this->db->table('rencana_rendev')->insert($data);
        if ($insert) {
            return json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }


    public function deleteRenOnsel()
    {

        // Delete the data by ID
        if ($this->db->table('rencana_rendev')->where('id', $this->request->getPost('id'))->delete()) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}

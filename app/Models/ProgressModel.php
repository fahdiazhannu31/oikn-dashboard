<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table            = 'progresses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getDedProgress()
    {
        return $this->db->table('jml_pkt_ded a')
            ->select('a.kat_ded_id, a.paket_ded_id, a.jml_paket, b.nama_paket, c.nama_ded')
            ->join('paket_ded b', 'a.paket_ded_id = b.id')
            ->join('kat_ded c', 'a.kat_ded_id = c.id') // Pastikan bergabung dengan tabel bidang
            ->get()
            ->getResult();
    }

    public function getResumeDEDData()
    {
        return $this->db->table('resume_ded')
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getClashDetectionData()
    {
        return $this->db->table('clash_detection')
            ->select('*')
            ->get()
            ->getResult();
    }


    public function getClashDetectionDatabyDate($selectedDate)
    {
        return $this->db->table('clash_detection')
            ->select('*')
            ->where('tgl_progress', $selectedDate)
            ->get()
            ->getResult();
    }
    public function getTglUpd()
    {
        return $this->db->table('clash_detection')
            ->select('*')
            ->orderBy('tgl_progress', 'DESC')
            ->limit(1)
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

    public function option_waktu_clash()
    {
        return $this->db->table('clash_detection')
            ->select('DISTINCT(tgl_progress)') // Menggunakan DISTINCT untuk mengambil tanggal unik
            ->orderBy('tgl_progress', 'DESC')
            ->get()
            ->getResult();
    }
}

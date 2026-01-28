<?php

namespace App\Models;

use CodeIgniter\Model;

class SMKKModel extends Model
{
    protected $table            = 'smkks';
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

    public function getDokumenSmkk()
    {
        return $this->db->table('smkk_dokumen')
            ->select('*')
            ->where('smkk_jenis_id', 1)
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)                                // Menambahkan limit 1
            ->get()
            ->getResult();
    }
    public function getDokumenSmkkbyDate($selectedDate)
    {
        return $this->db->table('smkk_dokumen')
            ->select('*')
            ->where('smkk_jenis_id', 1)
            ->orderBy('tgl_upd', $selectedDate)
            ->limit(1)                                // Menambahkan limit 1
            ->get()
            ->getResult();
    }

    public function getDashboardSmkk()
    {

        return $this->db->table('smkk_dashboard')
            ->select('*')
            ->where('smkk_jenis_id', 2)
            ->orderBy('tgl_upd', 'DESC')  // Filter berdasarkan tahun tgl_upd
            ->limit(1)                                // Menambahkan limit 1
            ->get()
            ->getResult();
    }

    public function getDashboardSmkkbyDate($selectedDate)
    {

        return $this->db->table('smkk_dashboard')
            ->select('*')
            ->where('smkk_jenis_id', 2)
            ->orderBy('tgl_upd', $selectedDate)  // Filter berdasarkan tahun tgl_upd
            ->limit(1)                                // Menambahkan limit 1
            ->get()
            ->getResult();
    }

    public function getCatatanSmkk()
    {
        return $this->db->table('jenis_smkk')
            ->select('*')
            ->where('id', 1)
            ->get()
            ->getResult();
    }

    public function getJenisSmkk()
    {
        return $this->db->table('jenis_smkk')
            ->select('*')
            ->get()
            ->getResult();
    }

    public function option_waktu_smkk()
    {
        return $this->db->table('smkk_dashboard')
            ->select('DISTINCT(tgl_upd)')
            ->where('smkk_jenis_id', 2) // Menggunakan DISTINCT untuk mengambil tanggal unik
            ->orderBy('tgl_upd', 'DESC')
            ->get()
            ->getResult();
    }
}

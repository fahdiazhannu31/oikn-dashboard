<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table            = 'laporan';
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

    function getLaporanMingguan()
    {
        return $this->db->table('detail_laporan')
            ->select('*')
            ->get()
            ->getResult();
    }
    function getLaporanMingguanById($id)
    {
        return $this->db->table('detail_laporan a')
            ->select('a.*, b.*') // Pastikan hanya kolom yang diperlukan dipilih
            ->join('file_laporan b', 'a.id = b.detail_laporan_id')
            ->where('a.id', $id) // Tambahkan kondisi untuk filter ID
            ->get()
            ->getResult();
    }
}

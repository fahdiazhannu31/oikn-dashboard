<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPekerjaModel extends Model
{
    protected $table            = 'data_pekerja_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getDataPekerjaMenu()
    {
        return $this->db->table('data_pekerja')
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getDataPekerjaChart($slug)
    {
        return $this->db->table('data_pekerja')
            ->select('*')
            ->where('slug', $slug)
            ->get()
            ->getResult();
    }
}

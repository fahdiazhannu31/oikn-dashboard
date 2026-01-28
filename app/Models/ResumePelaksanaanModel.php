<?php

namespace App\Models;

use CodeIgniter\Model;

class ResumePelaksanaanModel extends Model
{
    protected $table            = 'resume_pelaksanaan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class PerencanaanModel extends Model
{
    protected $table = 'perencanaan'; // Nama tabel perencanaan
    protected $primaryKey = 'id'; // Primary key dari tabel perencanaan

    public function getPerencanaanProgress()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        return $this->db->table('perencanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.jml_paket, a.progress_perencanaan, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('b.nama_batch !=', 'TOTAL')
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC')
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }
    public function getPerencanaanProgressByDate($selectedDate)
    {
        return $this->db->table('perencanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.jml_paket, a.progress_perencanaan, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('b.nama_batch !=', 'TOTAL')
            ->where('a.tgl_upd', $selectedDate)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC') //
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }
    public function getPerencanaanTotal()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        return $this->db->table('perencanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.jml_paket, a.progress_perencanaan, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('a.batch_id = 7')
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC')
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

    public function getPerencanaanTotalByDate($selectedDate)
    {
        return $this->db->table('perencanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.jml_paket, a.progress_perencanaan, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('a.batch_id = 7')
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

  public function getJmlRenrel()
    {
        return $this->db->table('rencana_rendev a')
            ->select('a.id, a.batch_id, a.rencana, a.realisasi, b.nama_batch, a.tgl_upd')
            ->join('batch b', 'a.batch_id = b.id_batch') // Pastikan bergabung dengan tabel bidang
            ->get()
            ->getResult();
    }


    public function getJmlRenrelByDate($selectedDate)
    {
        return $this->db->table('rencana_rendev a')
            ->select('a.id, a.batch_id, a.rencana, a.realisasi, b.nama_batch, a.tgl_upd')
            ->join('batch b', 'a.batch_id = b.id_batch') // Pastikan bergabung dengan tabel bidang
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }

    public function getJmlOnSel()
    {
        return $this->db->table('rencana_rendev a')
            ->select('a.id, a.batch_id, a.ren_ongoing, a.ren_sel, b.nama_batch, a.tgl_upd')
            ->join('batch b', 'a.batch_id = b.id_batch') // Pastikan bergabung dengan tabel bidang
            ->get()
            ->getResult();
    }

    public function getJmlOnSelByDate($selectedDate)
    {
        return $this->db->table('rencana_rendev a')
            ->select('a.id, a.batch_id, a.ren_ongoing, a.ren_sel, b.nama_batch, a.tgl_upd')
            ->join('batch b', 'a.batch_id = b.id_batch') // Pastikan bergabung dengan tabel bidang
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }

    public function getTglUpd()
    {
        return $this->db->table('perencanaan')
            ->select('*')
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }


    public function option_waktu_perencanaan()
    {
        return $this->db->table('perencanaan')
            ->select('DISTINCT(tgl_upd)') // Menggunakan DISTINCT untuk mengambil tanggal unik
            ->orderBy('tgl_upd', 'DESC')
            ->get()
            ->getResult();
    }

public function getLastTglUpd()
{
    return $this->db->table('perencanaan')
        ->select('tgl_upd')
        ->orderBy('tgl_upd', 'DESC')
        ->get()
        ->getRowArray();
}


}

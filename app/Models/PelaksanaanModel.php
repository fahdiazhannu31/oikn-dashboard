<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaanModel extends Model
{
    protected $table = 'pelaksanaan'; // Nama tabel pelaksanaan
    protected $primaryKey = 'id'; // Primary key dari tabel pelaksanaan

    public function getPelaksanaanProgress()
    {
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = date('m');
        $currentYear = date('Y');

        return $this->db->table('pelaksanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.ket_3, a.jml_paket, a.progress_fisik, a.total_pagu, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('b.nama_batch !=', 'TOTAL')
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC') // Urutkan berdasarkan tgl_upd terbaru
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

public function getLastTglUpd()
{
    return $this->db->table('pelaksanaan')
        ->select('tgl_upd')
        ->orderBy('tgl_upd', 'DESC')
        ->limit(1)
        ->get()
        ->getRowArray(); // ← hasil array
}



    public function getPelaksanaanProgressByDate($selectedDate)
    {


        return $this->db->table('pelaksanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.ket_3, a.jml_paket, a.progress_fisik, a.total_pagu, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('b.nama_batch !=', 'TOTAL')
            ->where('a.tgl_upd', $selectedDate)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC') // Urutkan berdasarkan tgl_upd terbaru
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

    public function option_waktu_pelaksanaan()
    {
        return $this->db->table('pelaksanaan')
            ->select('DISTINCT(tgl_upd)') // Menggunakan DISTINCT untuk mengambil tanggal unik
            ->orderBy('tgl_upd', 'DESC')
            ->get()
            ->getResult();
    }

    public function getTglUpd()
    {
        return $this->db->table('pelaksanaan a')
            ->select('*')
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }
    public function getPelaksanaanTotal()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        return $this->db->table('pelaksanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.ket_3, a.jml_paket, a.progress_fisik, a.total_pagu, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('a.batch_id = 7')
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear)   // Filter berdasarkan tahun
            ->orderBy('a.batch_id', 'ASC') // Urutkan berdasarkan tgl_upd terbaru
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }

    public function getPelaksanaanTotalByDate($selectedDate)
    {
        return $this->db->table('pelaksanaan a')
            ->select('a.id, a.ket_1, a.ket_2, a.ket_3, a.jml_paket, a.progress_fisik, a.total_pagu, a.tgl_upd, b.nama_batch')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->where('a.batch_id = 7')
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult(); // Mengembalikan hasil query
    }
    public function getJmlPaket()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        return $this->db->table('jml_pkt_bidang a')
            ->select('a.id, a.bidang_id, a.batch_id, a.jml_paket, b.nama_batch, c.nama_bidang')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->join('bidang c', 'a.bidang_id = c.id_bidang')
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear) // Pastikan bergabung dengan tabel bidang
            ->get()
            ->getResult();
    }
    public function getJmlPaketByDate($selectedDate)
    {
        return $this->db->table('jml_pkt_bidang a')
            ->select('a.id, a.bidang_id, a.batch_id, a.jml_paket, b.nama_batch, c.nama_bidang')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->join('bidang c', 'a.bidang_id = c.id_bidang')
            ->where('a.tgl_upd', $selectedDate) // Pastikan bergabung dengan tabel bidang
            ->get()
            ->getResult();
    }

    public function getJmlFisik()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        return $this->db->table('progress_fisik a')
            ->select('a.id_fisik, a.fisik_progress_id, a.batch_id, a.jml_progress, b.nama_batch, c.nama_progress_fisik')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->join('progress_perfisik c', 'a.fisik_progress_id = c.id') // Pastikan bergabung dengan tabel bidang
            ->where('MONTH(a.tgl_upd)', $currentMonth) // Filter berdasarkan bulan
            ->where('YEAR(a.tgl_upd)', $currentYear)
            ->get()
            ->getResult();
    }

    public function getJmlFisikByDate($selectedDate)
    {
        return $this->db->table('progress_fisik a')
            ->select('a.id_fisik, a.fisik_progress_id, a.batch_id, a.jml_progress, b.nama_batch, c.nama_progress_fisik')
            ->join('batch b', 'a.batch_id = b.id_batch')
            ->join('progress_perfisik c', 'a.fisik_progress_id = c.id') // Pastikan bergabung dengan tabel bidang
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }
    public function getResumeData()
    {
        return $this->db->table('resume_pelaksanaan')
            ->select('*')
            ->get()
            ->getResult();
    }
    public function getResumeDataByDate($selectedDate)
    {
        return $this->db->table('resume_pelaksanaan')
            ->select('*')
            ->where('tgl_data', $selectedDate)
            ->get()
            ->getResult();
    }

    public function getPerFisik()
    {
        return $this->db->table('progress_perfisik')
            ->select('*')
            ->get()
            ->getResult();
    }
}

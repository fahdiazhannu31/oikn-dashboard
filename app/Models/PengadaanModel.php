<?php

namespace App\Models;

use CodeIgniter\Model;

class PengadaanModel extends Model
{
    protected $table            = 'pengadaan_tanah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];


    public function getTitleJenisPengadaan()
    {
        return $this->db->table('jenis_pengadaan_tanah')
            ->select('nama_jenis')
            ->get()
            ->getResult();
    }

    public function getJenisPengadaan()
    {
        return $this->db->table('jenis_pengadaan_main')
            ->select('*')
            ->get()
            ->getResult();
    }


    public function getJenisPengadaanTanahbyDate($selectedDate, $slug)
    {
        return $this->db->table('jenis_pengadaan_tanah a')
            ->select(
                'a.id,
                a.jenis_main_id,
                a.total_kebutuhan_lahan,
                a.total_lahan_sudah_bebas,
                a.total_lahan_belum_bebas,
                a.total_lahan_bebas_value,
                a.total_lahan_belum_bebas_value,
                b.nama_jenis'
            )
            ->join('jenis_pengadaan_main b', 'a.jenis_main_id = b.id')
            ->where('b.slug', $slug)
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }


    public function getJenisPengadaanTanah($slug)
    {
        return $this->db->table('jenis_pengadaan_tanah a')
            ->select(
                'a.id,
                a.jenis_main_id,
                a.total_kebutuhan_lahan,
                a.total_lahan_sudah_bebas,
                a.total_lahan_belum_bebas,
                a.total_lahan_bebas_value,
                a.total_lahan_belum_bebas_value,
                b.nama_jenis'
            )
            ->join('jenis_pengadaan_main b', 'a.jenis_main_id = b.id')
            ->where('b.slug', $slug)
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }

    public function getPengadaanTanah($slug)
    {
        return $this->db->table('pengadaan_tanah a')
            ->select(
                'a.id',
                'a.jenis_pengadaan_tanah_id',
                'a.nama_paket',
                'a.kebutuhan_lahan',
                'a.kebutuhan_lahan_value',
                'a.sdh_bbs',
                'a.sdh_bbs_value',
                'a.blm_bebas',
                'a.blm_bebas_value',
                'a.siap_byr',
                'a.siap_bayar_value',
                'a.konsinyasi',
                'a.konsinyasi_value',
                'a.phk_undang',
                'a.phk_undang_value',
                'a.proses_penilaian_kjpp',
                'a.proses_penilaian_kjpp_value',
                'a.sdh_pengumuman',
                'a.sdh_pengumuman_value',
                'a.blm_pengumuman',
                'a.blm_pengumuman_value',
                'a.tanah_karakteristik',
                'a.tanah_karakteristik_value',
                'a.tgl_upd',
                'b.nama_jenis'
            )
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->where('b.slug', $slug)
            ->orderBy('tgl_upd', 'DESC')
            ->limit(1)
            ->get()
            ->getResult();
    }

    public function getDitjen()
    {
        return $this->db->table('jenis_pengadaan_main')
            ->select('*')
            ->get()
            ->getResult();
    }

    public function getTanahData($slug)
    {
        return $this->db->table('pengadaan_tanah a')
            ->select('a.id,
                    a.jenis_pengadaan_tanah_id,
                    a.nama_paket,
                    a.kebutuhan_lahan,
                    a.kebutuhan_lahan_value,
                    a.sdh_bbs,
                    a.sdh_bbs_value,
                    a.blm_bebas,
                    a.blm_bebas_value,
                    a.siap_byr,
                    a.siap_bayar_value,
                    a.konsinyasi,
                    a.konsinyasi_value,
                    a.phk_undang,
                    a.phk_undang_value,
                    a.proses_penilaian_kjpp,
                    a.proses_penilaian_kjpp_value,
                    a.sdh_pengumuman,
                    a.sdh_pengumuman_value,
                    a.blm_pengumuman,
                    a.blm_pengumuman_value,
                    a.tanah_karakteristik,
                    a.tanah_karakteristik_value, c.slug')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->join('jenis_pengadaan_main c', 'b.jenis_main_id = b.id')
            ->where('c.slug', $slug)
            ->get()
            ->getResult();
    }

    public function getTanahDatabyDate($selectedDate, $slug)
    {
        return $this->db->table('pengadaan_tanah a')
            ->select('a.id,
                    a.jenis_pengadaan_tanah_id,
                    a.nama_paket,
                    a.kebutuhan_lahan,
                    a.kebutuhan_lahan_value,
                    a.sdh_bbs,
                    a.sdh_bbs_value,
                    a.blm_bebas,
                    a.blm_bebas_value,
                    a.siap_byr,
                    a.siap_bayar_value,
                    a.konsinyasi,
                    a.konsinyasi_value,
                    a.phk_undang,
                    a.phk_undang_value,
                    a.proses_penilaian_kjpp,
                    a.proses_penilaian_kjpp_value,
                    a.sdh_pengumuman,
                    a.sdh_pengumuman_value,
                    a.blm_pengumuman,
                    a.blm_pengumuman_value,
                    a.tanah_karakteristik,
                    a.tanah_karakteristik_value, c.slug')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->join('jenis_pengadaan_main c', 'b.jenis_main_id = b.id')
            ->where('c.slug', $slug)
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }

    public function getPercepatanMasalahbyDate($selectedDate, $slug)
    {
        return $this->db->table('masalah_percepatan a')
            ->select('*')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->join('jenis_pengadaan_main c', 'b.jenis_main_id = b.id')
            ->where('c.slug', $slug)
            ->where('a.tgl_upd', $selectedDate)
            ->get()
            ->getResult();
    }

    public function getPercepatanMasalah($slug)
    {
        return $this->db->table('masalah_percepatan a')
            ->select('*')
            ->join('jenis_pengadaan_tanah b', 'a.jenis_pengadaan_tanah_id = b.id')
            ->join('jenis_pengadaan_main c', 'b.jenis_main_id = b.id')
            ->where('c.slug', $slug)
            ->get()
            ->getResult();
    }

    public function option_waktu_pengadaan($slug)
    {
        return $this->db->table('jenis_pengadaan_tanah a')
            ->select('DISTINCT(a.tgl_upd)') // Menggunakan DISTINCT untuk mengambil tanggal unik
            ->join('jenis_pengadaan_main b', 'a.jenis_main_id = b.id')
            ->where('b.slug', $slug)
            ->orderBy('a.tgl_upd', 'DESC')
            ->get()
            ->getResult();
    }
}

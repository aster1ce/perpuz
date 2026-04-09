<?php

class M_Admin extends CI_Model
{
    public function get_stats()
    {
        $data['total_user'] = $this->db->count_all('users');
        $data['total_buku'] = $this->db->count_all('buku');

        // Gunakan result_array() dan pastikan query simpel
        $status_query = $this->db->query("SELECT status, COUNT(*) as jumlah FROM peminjaman GROUP BY status");
        $data['status_counts'] = $status_query ? $status_query->result_array() : [];

        // Kategori Favorit (Gue rapihin dikit biar gak ambigu kolomnya)
        $this->db->select('b.kategori, COUNT(p.id_peminjaman) as total');
        $this->db->from('buku b');
        $this->db->join('peminjaman p', 'p.id_buku = b.id_buku', 'left');
        $this->db->group_by('b.kategori');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(3);
        $kategori_query = $this->db->get();
        $data['kategori_fav'] = $kategori_query ? $kategori_query->result() : [];

        // Log Aktivitas (Tersangka Utama Error 500)
        // Kita pake LEFT JOIN biar kalau user/buku ada yang kehapus, admin gak blank putih
        $this->db->select('p.*, u.nama_lengkap, b.judul');
        $this->db->from('peminjaman p');
        $this->db->join('users u', 'p.id_user = u.id_user', 'left');
        $this->db->join('buku b', 'p.id_buku = b.id_buku', 'left');
        $this->db->order_by('p.id_peminjaman', 'DESC');
        $this->db->limit(5);
        $log_query = $this->db->get();
        $data['log_aktivitas'] = $log_query ? $log_query->result() : [];

        return $data;
    }

    public function get_peminjaman_mingguan()
    {
        // VERSI FIX UNTUK LARAGON/MYSQL STRICT MODE
        // GROUP BY harus sama dengan yang di SELECT
        $query = $this->db->query("
            SELECT DAYNAME(tanggal_pinjam) as hari, COUNT(*) as jumlah 
            FROM peminjaman 
            WHERE tanggal_pinjam >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY tanggal_pinjam, hari 
            ORDER BY tanggal_pinjam ASC
        ");
        return $query ? $query->result_array() : [];
    }
}
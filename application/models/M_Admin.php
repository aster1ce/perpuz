<?php

class M_Admin extends CI_Model
{
    public function get_stats()
    {
        // 1. Total (Pake users pake S sesuai screenshot lo)
        $data['total_user'] = $this->db->count_all('users');
        $data['total_buku'] = $this->db->count_all('buku');

        // 2. Status Peminjaman (Gue pake query manual biar lebih enteng & aman)
        $status_query = $this->db->query("SELECT status, COUNT(*) as jumlah FROM peminjaman GROUP BY status");
        $data['status_counts'] = $status_query ? $status_query->result_array() : [];

        // 3. Kategori Favorit
        // Kita hitung berdasarkan tabel buku, join ke peminjaman
        $this->db->select('buku.kategori, COUNT(peminjaman.id_peminjaman) as total');
        $this->db->from('buku');
        $this->db->join('peminjaman', 'peminjaman.id_buku = buku.id_buku', 'left');
        $this->db->group_by('buku.kategori');
        $this->db->order_by('total', 'DESC');
        $this->db->limit(3);
        $kategori_query = $this->db->get();
        $data['kategori_fav'] = $kategori_query ? $kategori_query->result() : [];

        // 4. Log Aktivitas
        // Gue tambahin aliases 'p', 'u', 'b' biar query-nya gak pusing
        $this->db->select('p.*, u.nama_lengkap, b.judul');
        $this->db->from('peminjaman p');
        $this->db->join('users u', 'p.id_user = u.id_user');
        $this->db->join('buku b', 'p.id_buku = b.id_buku');
        $this->db->order_by('p.id_peminjaman', 'DESC');
        $this->db->limit(5);
        $log_query = $this->db->get();
        $data['log_aktivitas'] = $log_query ? $log_query->result() : [];

        return $data;
    }

    public function get_peminjaman_mingguan()
    {
        $query = $this->db->query("
        SELECT DAYNAME(tanggal_pinjam) as hari, COUNT(*) as jumlah 
        FROM peminjaman 
        WHERE tanggal_pinjam >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DAYOFWEEK(tanggal_pinjam)
        ORDER BY tanggal_pinjam ASC
    ");
        return $query->result_array();
    }
}
<?php
class M_User extends CI_Model
{

    // Tambahkan fungsi ini di dalam class M_User
    public function count_siswa()
    {
        $this->db->where('role', 'siswa');
        return $this->db->count_all_results('users');
    }

    public function get_pagination_siswa($limit, $start)
    {
        $this->db->where('role', 'siswa');
        return $this->db->get('users', $limit, $start)->result();
    }
}
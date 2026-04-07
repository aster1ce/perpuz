<?php 


class M_Auth extends CI_Model { // Nama Class harus M_Auth
    public function cek_login($table, $where) {
        return $this->db->get_where($table, $where);
    }
}

?>
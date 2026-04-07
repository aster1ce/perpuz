<?php
class M_Buku extends CI_Model
{

    function tampil_data()
    {
        return $this->db->get('buku');
    }

    function input_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    // ini teh buat nambah page (poho)
    public function get_pagination($limit, $start) {
        return $this->db->get('buku', $limit, $start)->result();
    }
    public function count_all() {
        return $this->db->get('buku')->num_rows();
    }
}



?>
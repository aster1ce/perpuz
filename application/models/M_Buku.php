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
}



?>
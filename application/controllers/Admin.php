<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('status') != "login" || $this->session->userdata('role') != "admin") {

        }
        $this->load->model('M_Buku');
    }

    public function index()
    {
        $data['buku'] = $this->M_Buku->tampil_data()->result();
        $this->load->view('admin/v_index', $data);
    }

    //Buat tambah buku bisi poho 
    public function tambah_aksi()
    {
        $data = array(
            'judul' => $this->input->post('judl'),
            'penulis' => $this->input->post('penulis'),
            'stok' => $this->input->post('stok')
        );
        $this->M_Buku->input_data($data, 'buku');
        redirect('admin/index');
    }

    // Buat ngahapus
    public function hapus($id)
    {
        $where = array('id_buku' => $id);
        $this->M_Buku->hapus_data($where, 'buku');
        redirect('admin/index');
    }
}


?>
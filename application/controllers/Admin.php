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
        $this->load->view('layout/v_sidebar');
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

    public function transaksi()
    {
        // Join tabel
        $this->db->select('peminjaman.*, users.nama_lengkap, buku.judul');
        $this->db->from('peminjaman');
        $this->db->join('users', 'users.id_user = peminjaman.id_user');
        $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $data['transaksi'] = $this->db->get()->result();

        $this->load->view('layout/v_sidebar');
        $this->load->view('admin/v_transaksi', $data);
    }

    public function setuju_pinjam($id_peminjaman, $id_buku)
    {
        // apdet status 
        $this->db->where('id_peminjaman', $id_peminjaman);
        $this->db->update('peminjaman', ['status' => 'disetujui', 'tanggal_kembali' => date('Y-m-d', strtotime('+7 days'))]);


        // stok
        $this->db->set('stok', 'stok - 1', FALSE);
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku');

        redirect('admin/transaksi');
    }

    public function konfirmasi_kembali($id_peminjaman, $id_buku)
    {
        // apdet status
        $this->db->where('id_peminjaman', $id_peminjaman);
        $this->db->update('peminjaman', ['status' => 'kembali']);

        // stok balik
        $this->db->set('stok', 'stok + 1', FALSE);
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku');

        redirect('admin/transaksi');
    }
}


?>
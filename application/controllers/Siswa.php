<?php
class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login" || $this->session->userdata('role') != "siswa") {
            redirect(base_url("auth"));
        }
    }

    public function index()
    {
        $this->load->view('layout/v_sidebar');
        $this->load->view('siswa/v_index');
    }

    public function buku()
    {
        $this->load->model('M_Buku');
        $data['buku'] = $this->M_Buku->tampil_data()->result();

        $this->load->view('layout/v_sidebar');
        $this->load->view('siswa/v_buku', $data);
    }

    public function pinjam_aksi($id_buku)
    {
        $this->load->model('M_Buku');

        $data = array(
            'id_user' => $this->session->userdata('id'),
            'id_buku' => $id_buku,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')), // Pinjam 7 hari
            'status' => 'menunggu'
        );


        $this->db->insert('peminjaman', $data);
        $this->session->set_flashdata('Pesan', 'Pengajuan berhasil dikirim!');

        redirect('siswa/buku');
    }


    public function riwayat()
    {
        $id_user = $this->session->userdata('id');
        $filter = $this->input->get('filter');

        $this->db->select('peminjaman.*, buku.judul');
        $this->db->from('peminjaman');
        $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $this->db->where('peminjaman.id_user', $id_user);

        // filter 
        if ($filter) {
            $this->db->where('peminjaman.status', $filter);

        }

        $this->db->order_by('id_peminjaman', 'DESC');
        $data['riwayat'] = $this->db->get()->result();

        $this->load->view('layout/v_sidebar');
        $this->load->view('siswa/v_riwayat', $data);
    }
}
?>
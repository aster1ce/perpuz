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
        $id_user = $this->session->userdata('id_user');
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

    public function batal_pinjam($id)
    {
        $where = array('id_peminjaman' => $id, 'status' => 'menunggu');
        $this->db->delete('peminjaman', $where);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('pesan', 'Berhasil dibatalkan');
        }
        redirect('siswa/riwayat');
    }

    public function ajukan_kembali($id)
    {
        $this->db->where('id_peminjaman', $id);
        $this->db->update('peminjaman', ['status' => 'pending_kembali']);
        redirect('siswa/riwayat');
    }

    public function proses_pinjam()
    {
        $tgl_pinjam = $this->input->post('tanggal_pinjam');

        // Logika MTK: Tambah 3 hari dari tanggal pinjam
        $tgl_deadline = date('Y-m-d', strtotime($tgl_pinjam . ' +3 days'));

        $data = [
            'id_user' => $this->session->userdata('id_user'),
            'id_buku' => $this->input->post('id_buku'),
            'tanggal_pinjam' => $tgl_pinjam,
            'tanggal_deadline' => $tgl_deadline,
            'status' => 'menunggu',
            'denda' => 0
        ];

        $this->db->insert('peminjaman', $data);
        redirect('siswa/riwayat');
    }

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Buku');
        $this->load->model('M_User');
        $this->load->library('pagination');

        if ($this->session->userdata('status') != "login" || $this->session->userdata('role') != "admin") {

        }

        $this->load->library('pagination');
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
            'judul' => $this->input->post('judul'),
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
        // Ambil parameter filter dari URL (misal: ?status=kembali)
        $status_filter = $this->input->get('status');

        $this->db->select('peminjaman.*, users.nama_lengkap, buku.judul');
        $this->db->from('peminjaman');
        $this->db->join('users', 'users.id_user = peminjaman.id_user', 'left');
        $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left');

        // Jika ada filter yang dipilih, tambahkan kondisi WHERE
        if ($status_filter) {
            $this->db->where('peminjaman.status', $status_filter);
        }

        $this->db->order_by('id_peminjaman', 'DESC');
        $query = $this->db->get()->result();

        foreach ($query as $row) {
            // 1. Cek dulu, apakah di DB sudah ada denda permanen (status 'kembali')?
            if ($row->status == 'kembali') {
                continue;
            }

            // 2. Hitung denda otomatis untuk status disetujui atau pending_kembali
            if ($row->status == "disetujui" || $row->status == "pending_kembali") {
                $deadline = strtotime($row->tanggal_deadline);
                $sekarang = strtotime(date('Y-m-d'));

                if ($sekarang > $deadline) {
                    $selisih_hari = floor(($sekarang - $deadline) / (60 * 60 * 24));
                    $row->denda = $selisih_hari * 2000;
                } else {
                    $row->denda = 0;
                }
            }
        }

        $data['transaksi'] = $query;
        $data['status_aktif'] = $status_filter; // Buat nandain filter mana yang lagi dipake

        $this->load->view('layout/v_sidebar');
        $this->load->view('admin/v_transaksi', $data);
    }

    public function setuju_pinjam($id_peminjaman, $id_buku)
    {
        $this->db->where('id_peminjaman', $id_peminjaman);
        $this->db->update('peminjaman', [
            'status' => 'disetujui',
            'tanggal_deadline' => date('Y-m-d', strtotime('+3 days')) // Sesuaikan 3 hari
        ]);

        $this->db->set('stok', 'stok - 1', FALSE);
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku');

        redirect('admin/transaksi');
    }

    public function tolak_pinjam($id_peminjaman)
    {
        // Cukup update status jadi ditolak, stok tidak berubah karena belum dikurangi
        $this->db->where('id_peminjaman', $id_peminjaman);
        $this->db->update('peminjaman', ['status' => 'ditolak']);

        $this->session->set_flashdata('pesan', 'Peminjaman buku telah ditolak.');
        redirect('admin/transaksi');
    }

    public function ajukan_kembali($id)
    {
        $this->db->where('id_peminjaman', $id);
        $this->db->update('peminjaman', ['status' => 'pending_kembali']);

        $this->session->set_flashdata('pesan', 'Pengajuan pengembalian dikirim. Serahkan buku ke pustakawan.');
        redirect('siswa/riwayat');
    }

    public function konfirmasi_kembali($id_peminjaman, $id_buku)
    {
        // 1. Ambil data buat tau deadline
        $pinjam = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();

        // 2. LOGIKA MTK DENDA (Hanya hitung saat Admin klik konfirmasi)
        $tgl_deadline = strtotime($pinjam->tanggal_deadline);
        $tgl_kembali_real = strtotime(date('Y-m-d'));

        $denda = 0;
        if ($tgl_kembali_real > $tgl_deadline) {
            $selisih_detik = $tgl_kembali_real - $tgl_deadline;
            $selisih_hari = $selisih_detik / (60 * 60 * 24);
            $denda = $selisih_hari * 2000;
        }

        // 3. Update status & denda
        $this->db->where('id_peminjaman', $id_peminjaman);
        $this->db->update('peminjaman', [
            'status' => 'kembali',
            'tanggal_kembali_real' => date('Y-m-d'),
            'denda' => $denda
        ]);

        // 4. Update STOK: Baru nambah sekarang karena buku sudah di tangan Admin
        $this->db->set('stok', 'stok+1', FALSE);
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku');

        $this->session->set_flashdata('pesan', 'Buku berhasil diterima!');
        redirect('admin/transaksi');
    }

    public function konfirmasi_kembali_aksi()
    {
        $id_peminjaman = $this->input->post('id_peminjaman');
        $id_buku = $this->input->post('id_buku');
        $nominal_duit = $this->input->post('denda_dibayar');

        // Simpan ke database: status jadi 'kembali', denda diisi nominal yang dibayar
        $this->db->update('peminjaman', [
            'status' => 'kembali',
            'denda' => $nominal_duit, // Nominal ini masuk ke database secara permanen
            'tanggal_kembali_real' => date('Y-m-d')
        ], ['id_peminjaman' => $id_peminjaman]);

        // Update stok buku (+1)
        $this->db->set('stok', 'stok+1', FALSE);
        $this->db->where('id_buku', $id_buku);
        $this->db->update('buku');

        $this->session->set_flashdata('pesan', 'Denda lunas dan buku telah kembali!');
        redirect('admin/transaksi');
    }



    // buku
    public function kelola_buku($start = 0)
    {
        $config['base_url'] = base_url('admin/kelola_buku');
        $config['total_rows'] = $this->M_Buku->count_all();
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $data['buku'] = $this->M_Buku->get_pagination($config['per_page'], $start);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layout/v_sidebar');
        $this->load->view('admin/v_kelola_buku', $data);
    }

    public function buku_add()
    {
        $data = [
            'judul' => $this->input->post('judul'),
            'penulis' => $this->input->post('penulis'),
            'stok' => $this->input->post('stok')
        ];
        $this->db->insert('buku', $data);
        redirect('admin/kelola_buku');
    }

    public function buku_edit()
    {
        $id = $this->input->post('id_buku');
        $data = [
            'judul' => $this->input->post('judul'),
            'penulis' => $this->input->post('penulis'),
            'stok' => $this->input->post('stok')
        ];
        $this->db->where('id_buku', $id);
        $this->db->update('buku', $data);
        redirect('admin/kelola_buku');

    }


    public function buku_delete($id)
    {
        $this->db->delete('buku', ['id_buku' => $id]);
        redirect('admin/kelola_buku');
    }

    // pagination yahudi + kelola user
    public function kelola_user($start = 0)
    {
        $config['base_url'] = base_url('admin/kelola_user');
        $config['total_rows'] = $this->M_User->count_siswa();
        $config['per_page'] = 5;

        $this->pagination->initialize($config);
        $data['user'] = $this->M_User->get_pagination_siswa($config['per_page'], $start);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layout/v_sidebar');
        $this->load->view('admin/v_kelola_user', $data);
    }

    public function user_add()
    {
        $data = [
            'username' => $this->input->post('username'),
            // GANTI md5 JADI password_hash
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'role' => 'siswa'
        ];
        $this->db->insert('users', $data);
        redirect('admin/kelola_user');
    }

    public function user_edit()
    {
        $id = $this->input->post('id_user');
        $data = [
            'username' => $this->input->post('username'),
            'nama_lengkap' => $this->input->post('nama_lengkap')
        ];

        // Update password 
        if ($this->input->post('password')) {

            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->db->where('id_user', $id);
        $this->db->update('users', $data);
        redirect('admin/kelola_user');
    }

    public function user_delete($id)
    {

        $this->db->where('id_user', $id);
        $this->db->delete('users');

        // 2. Set pesan sukses (opsional biar keren pas sidang)
        $this->session->set_flashdata('pesan', 'Data anggota berhasil dihapus!');

        // 3. Balikin ke halaman daftar user
        redirect('admin/kelola_user');
    }

    public function laporan()
{
    $tgl_mulai = $this->input->get('tgl_mulai');
    $tgl_selesai = $this->input->get('tgl_selesai');

    if ($tgl_mulai && $tgl_selesai) {
        $this->db->where('tanggal_pinjam >=', $tgl_mulai);
        $this->db->where('tanggal_pinjam <=', $tgl_selesai);
    }

    $this->db->select('peminjaman.*, users.nama_lengkap, buku.judul');
    $this->db->from('peminjaman');
    $this->db->join('users', 'users.id_user = peminjaman.id_user', 'left');
    $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left');
    $data['laporan'] = $this->db->get()->result();
    
    // (Summary)
    $data['total_pinjam'] = count($data['laporan']);
    $data['total_denda'] = 0;
    foreach($data['laporan'] as $l) {
        $data['total_denda'] += $l->denda;
    }

    $data['tgl_mulai'] = $tgl_mulai;
    $data['tgl_selesai'] = $tgl_selesai;

    $this->load->view('layout/v_sidebar');
    $this->load->view('admin/v_laporan', $data);
}


}


?>
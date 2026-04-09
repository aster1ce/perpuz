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
        $id_user = $this->session->userdata('id_user');

        // 1. Hitung Total Buku yang sedang dipinjam (Status: disetujui)
        $data['total_pinjam'] = $this->db->where([
            'id_user' => $id_user,
            'status' => 'disetujui'
        ])->count_all_results('peminjaman');

        // 2. Hitung Total Selesai (Status: kembali)
        $data['total_selesai'] = $this->db->where([
            'id_user' => $id_user,
            'status' => 'kembali'
        ])->count_all_results('peminjaman');

        // 3. Ambil Total Denda yang SUDAH LUNAS (History)
        // Query ini bakal menjumlahkan semua denda yang status bayarnya sudah 'lunas'
        $denda_query = $this->db->select_sum('denda')
            ->where('id_user', $id_user)
            ->where('status_bayar', 'lunas') // Ganti dari 'belum' ke 'lunas'
            ->get('peminjaman')
            ->row();

        // Sesuaikan nama variabel dengan yang ada di v_index.php (v_dashboard)
        $data['total_denda_lunas'] = $denda_query->denda ?? 0;

        // 4. Ambil 3 Riwayat Terakhir buat Bento Box
        $this->db->select('peminjaman.*, buku.judul');
        $this->db->from('peminjaman');
        $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $this->db->where('peminjaman.id_user', $id_user);
        $this->db->order_by('id_peminjaman', 'DESC');
        $this->db->limit(3);
        $data['riwayat_terakhir'] = $this->db->get()->result();

        // Load views
        $this->load->view('layout/v_sidebar');
        $this->load->view('siswa/v_index', $data);
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
            'tanggal_kembali' => date('Y-m-d', strtotime('+3 days')),
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

        // 1. Load Library Pagination
        $this->load->library('pagination');

        // 2. Konfigurasi Pagination
        $config['base_url'] = base_url('siswa/riwayat');
        $config['total_rows'] = $this->_count_riwayat($id_user, $filter);
        $config['per_page'] = 5;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE; // Penting biar filter gak ilang pas pindah page

        // Styling Pagination (Biar rapih di view)
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm justify-content-end m-0" style="display:flex; list-style:none; gap:5px;">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#" style="background:#333; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('style' => 'padding:5px 10px; border:1px solid #ddd; border-radius:5px; text-decoration:none; color:#333;');

        $this->pagination->initialize($config);

        // 3. Ambil Offset (Halaman ke berapa)
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // 4. Query Data
        $this->db->select('peminjaman.*, buku.judul');
        $this->db->from('peminjaman');
        $this->db->join('buku', 'buku.id_buku = peminjaman.id_buku');
        $this->db->where('peminjaman.id_user', $id_user);

        if ($filter) {
            $this->db->where('peminjaman.status', $filter);
        }

        $this->db->order_by('id_peminjaman', 'DESC');
        $this->db->limit($config['per_page'], $page); 

        $data['riwayat'] = $this->db->get()->result();
        $data['pagination'] = $this->pagination->create_links();
        $data['no'] = $page + 1; // Untuk penomoran di tabel agar berkelanjutan

        // 5. Load Views
        $this->load->view('layout/v_sidebar');
        $this->load->view('siswa/v_riwayat', $data);
    }

    // Helper untuk menghitung total baris (Wajib ada buat pagination)
    private function _count_riwayat($id_user, $filter)
    {
        $this->db->where('id_user', $id_user);
        if ($filter) {
            $this->db->where('status', $filter);
        }
        return $this->db->count_all_results('peminjaman');
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

        echo "Isi ID User: " . $this->session->userdata('id_user');
        die();
    }

}
?>
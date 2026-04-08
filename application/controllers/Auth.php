<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Auth extends CI_Controller
{
    public function index()
    {
        $this->load->view('v_login');
    }

    public function login()
    {
        $this->load->view('v_login'); // pastiin nama file view login-nya bener
    }

    public function login_aksi()
    {
        $this->load->model('M_Auth');
        $user = trim($this->input->post('username'));
        $pass = trim($this->input->post('password'));

        $where = array('username' => $user);
        $cek = $this->M_Auth->cek_login("users", $where)->row_array();

        if ($cek && password_verify($pass, $cek['password'])) {
            // LOGIN BERHASIL
            $data_session = array(
                'id_user' => $cek['id_user'],
                'nama' => $cek['nama_lengkap'],
                'role' => $cek['role'],
                'status' => "login"
            );
            $this->session->set_userdata($data_session);

            if ($cek['role'] == "admin") {
                redirect(base_url("admin"));
            } else {
                redirect(base_url("siswa"));
            }
        } else {
            // LOGIN GAGAL
            echo "Username atau Password salah!";
        }
    }

    public function registrasi()
    {
        $this->load->view('v_registrasi');
    }

    public function registrasi_aksi()
    {
        $nama = $this->input->post('nama_lengkap');
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $data = [
            'nama_lengkap' => $nama,
            'username' => $user,
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => 'siswa'     // Otomatis jadi siswa
        ];

        $this->db->insert('users', $data);
        $this->session->set_flashdata('pesan', 'Registrasi Berhasil! Silakan Login.');
        redirect('auth/login');
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
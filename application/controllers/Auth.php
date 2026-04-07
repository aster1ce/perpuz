<?php
class Auth extends CI_Controller
{

    public function index()
    {
        $this->load->view('v_login');
    }

    public function login_aksi()
    {

        $this->load->model('M_Auth');
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $where = array('username' => $user, 'password' => $pass); // Nanti bisa pakai password_verify
        $cek = $this->M_Auth->cek_login("users", $where)->row_array();

        if ($cek) {
            $data_session = array(
                'id' => $cek['id_user'],
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
            echo "Username dan password salah!";
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}
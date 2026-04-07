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
        echo "<h1>Dashboard Siswa</h1>";
        echo "<p>Selamat Datang, " . $this->session->userdata('nama') . "! <a href='" . base_url('auth/logout') . "'>Logout</a></p>";
    }
}
?>
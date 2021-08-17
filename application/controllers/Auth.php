<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    /**
     * Ini adalah consturctor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("UsersModel");
    }


    /**
     * Ini method index untuk menampilkan view
     */
    public function index()
    {
        if (isset($_SESSION["isLoggedIn"]) && isset($_SESSION["isLoggedIn"]) == true) {
            redirect("Dashboard");
        } else {
            $data = [
                'title' => 'Login',
                'content' => 'vLogin',
            ];

            $this->load->view('vLogin', $data);
        }
    }


    /**
     * Ini adalah progress login
     */
    public function progress_login()
    {
        $password_field = $this->input->post("password");
        $username_field = $this->input->post("username");
        $is_logged_in = false;
        $data_from_db = $this->UsersModel->getByUsername($username_field);

        if ($data_from_db) {
            $password_from_db = $data_from_db->password;

            if (password_verify($password_field, $password_from_db)) {
                // Statement ketika login berhasil
                $is_logged_in = true;
                $session = [
                    'is_logged_in' => $is_logged_in,
                    'username' => $data_from_db->username,
                    'id_user' => $data_from_db->id,
                    'fullname' => $data_from_db->fullname,
                    'token' => $data_from_db->token
                ];
                $this->session->set_userdata($session);
                redirect("Dashboard");
            } else {
                // Statement ketika login gagal
                $is_logged_in = false;
            }
        } else {
            // username salah
            $is_logged_in = false;
        }

        if ($is_logged_in === false) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger' role='alert'>Username atau password salah !</div>");
            redirect("Auth");
        }
    }


    /**
     * Ini adalah progress logout
     */
    public function progress_logout()
    {
        $this->session->sess_destroy();
        redirect("Auth");
    }
}

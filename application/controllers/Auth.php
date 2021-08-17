<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("UsersModel");
    }
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

    public function login()
    {
        $passwordField = $this->input->post("password");
        $usernameField = $this->input->post("username");
        $isLoggedIn = false;

        $dataFromDb = $this->UsersModel->getByUsername($usernameField);
        if ($dataFromDb) {
            $passwordFromDb = $dataFromDb->password;
            if (password_verify($passwordField, $passwordFromDb)) {
                // login berhasil
                $isLoggedIn = true;
                $session = [
                    'isLoggedIn' => $isLoggedIn,
                    'username' => $dataFromDb->username,
                    'id_user' => $dataFromDb->id,
                    'fullname' => $dataFromDb->fullname,
                    'token' => $dataFromDb->token
                ];
                $this->session->set_userdata($session);
                redirect("Dashboard");
            } else {
                // password salah
                $isLoggedIn = false;
            }
        } else {
            // username salah
            $isLoggedIn = false;
        }
        if ($isLoggedIn === false) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger' role='alert'>Username atau password salah !</div>");
            redirect("Auth");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("Auth");
    }
}

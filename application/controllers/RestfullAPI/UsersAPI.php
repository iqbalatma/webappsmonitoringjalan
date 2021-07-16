<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class UsersAPI extends REST_Controller
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
        // $this->load->model("UsersModel");
    }
    public function index_get($username = "", $password = "")
    {
        $data = null;
        if (!empty(trim($username)) && !empty(trim($password))) {
            $data = $this->db->get_where("users", ['username' => $username])->row_array();
            if ($data) { //username benar
                $passwordFromDb = $data["password"];
                if (password_verify($password, $passwordFromDb)) { //password benar
                    $isLoggedIn = true;
                    $session = [
                        'isLoggedIn' => $isLoggedIn,
                        'username' => $data["username"],
                        'id_user' => $data["id"],
                        'fullname' => $data["fullname"],
                        'token' => $data["token"]
                    ];
                    $this->session->set_userdata($session);


                    $this->response([
                        [
                            "message" => "true",
                            "data" => $data,
                        ]
                    ], REST_Controller::HTTP_OK);
                } else { //password salah
                    $this->response([[
                        "message" => "false",
                        "data" => "empty"
                    ]], REST_Controller::HTTP_NOT_FOUND);
                }
            } else { //username salah
                $this->response([[
                    "message" => "false",
                    "data" => "empty"
                ]], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}

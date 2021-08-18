<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class UsersAPI extends REST_Controller
{

    /**
     * Ini adalah consturctor
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Ini adalah method untuk get
     */
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

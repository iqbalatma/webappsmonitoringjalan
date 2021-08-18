<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class LocationAPI extends REST_Controller
{
    /**
     * Ini adalah consturctor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("LocationModel");
    }


    /**
     * Ini method http request
     */
    public function index_post()
    {
        // data dari method post, dimasukkan dalam variabel input dengan masing-masing valuanya kemudian di insert kedalam database
        $input = $this->input->post();
        $this->LocationModel->saveAcc($input);
        $this->response(
            [
                [
                    "message" => "Data Berhasil Ditambahkan",
                    "data" => [$input]
                ]
            ],
            REST_Controller::HTTP_OK
        );
    }
}

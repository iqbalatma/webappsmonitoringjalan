<?php


defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class LocationAPI extends REST_Controller
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
        $this->load->model("LocationModel");
    }
    public function index_get($id = 0)
    {
        if (!empty($id)) { //kalau idnya tidak empty maka cari berdasarkan id
            // $data = $this->AccelerometerModel->getById($id);
        } else { //kalau idnya kosong maka tampilkan keseluruhan
            // $data = $this->db->get("accelerometer")->result();
            //ambil data dari model, sesuaikan dengan kebutuhan field
            $data = $this->LocationMode->getAll();
        }


        if ($data) { //kalau data ada pada database akan merespon dan mengembalikan data
            $this->response(
                [
                    [
                        "message" => "Data berhasil didapatkan",
                        "data" => $data
                    ]
                ],
                REST_Controller::HTTP_OK
            );
        } else { //kalau data tidak terdapat pada database maka akan mengirimkan pesan data not found
            $this->response(["message" => "Data tidak ditemukan"], REST_Controller::HTTP_OK);
        }
    }





    public function index_post()
    {
        $input = $this->input->post(); // data dari method post, dimasukkan dalam variabel input dengan masing-masing valuanya kemudian di insert kedalam database



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




    //http delete belum digunakan
    public function index_delete($id)
    {

        $data = $this->db->get_where("accelerometer", ['id' => $id])->row_array();
        if ($data) {
            $delete = $this->db->delete("accelerometer", array('id' => $id));
            $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['Deleted item failed.'], REST_Controller::HTTP_OK);
        }
    }
}

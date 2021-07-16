<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maps extends CI_Controller
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
        $this->load->model("AccelerometerModel");
        $this->load->model("AltitudeModel");
        $this->load->model("LocationModel");
        $this->load->model("UphillroadModel");
    }



    public function index()
    {

        $data_coordinat = array();
        $data_altitude = $this->AltitudeModel->getAll();
        foreach ($data_altitude as $row) :
            array_push($data_coordinat, [$row->latitude, $row->longitude, $row->altitude]);
        endforeach;

        $dataJalanRusak = array();
        $dataJalanRusakDariDB = $this->LocationModel->getDataRusak();
        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->latitude, $row->longitude, $row->status]);
        endforeach;

        $data = [
            'title' => 'Maps',
            'content' => 'vMaps',
            'data_altitude' => $data_coordinat,
            'data_jalan_rusak' => $dataJalanRusak,
        ];
        $this->load->view('templateDashboard/wrapper', $data);
    }



    public function deteksijalan()
    {

        $data_coordinat = array();
        $data_altitude = $this->AltitudeModel->getAll();
        foreach ($data_altitude as $row) :
            array_push($data_coordinat, [$row->latitude, $row->longitude, $row->altitude]);
        endforeach;

        $dataJalanRusak = array();
        $dataJalanRusakDariDB = $this->LocationModel->getDataRusakTerverifikasi();
        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->latitude, $row->longitude, $row->status]);
        endforeach;

        $data = [
            'title' => 'Maps',
            'content' => 'vMapsMobileDeteksiJalanRusak',
            'data_altitude' => $data_coordinat,
            'data_jalan_rusak' => $dataJalanRusak,
        ];


        $this->load->view('TemplateMap/wrapper', $data);
    }


    public function petadigital($dataJalan = "")
    {
        if ($dataJalan !== "") {
            switch ($dataJalan) {
                case "1":
                    $dataJalanRusakDariDB = $this->LocationModel->getDinamisQuery("SELECT * FROM location WHERE status='rusak' AND verifikasi = 1");
                    break;
                case "2":
                    $dataJalanRusakDariDB = $this->LocationModel->getDinamisQuery("SELECT * FROM location WHERE status='rusak' AND verifikasi = 0");
                    break;
                case "3":
                    $dataJalanRusakDariDB = $this->LocationModel->getDinamisQuery("SELECT * FROM location WHERE status='Tidak Rusak' AND verifikasi = 1");
                    break;
                case "4":
                    $dataJalanRusakDariDB = $this->LocationModel->getDinamisQuery("SELECT * FROM location WHERE status='Diperbaiki' AND verifikasi = 1");
                    break;
                default:
                    echo " code to be executed if n is different from all labels";
            }
        } else {
            $dataJalanRusakDariDB = $this->LocationModel->getDataRusakTerverifikasi();
        }
        $data_coordinat = array();
        $data_altitude = $this->AltitudeModel->getAll();
        foreach ($data_altitude as $row) :
            array_push($data_coordinat, [$row->latitude, $row->longitude, $row->altitude]);
        endforeach;

        $dataJalanRusak = array();
        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status, $row->img_path, $row->verifikasi]);
        endforeach;

        $dataJalanMenanjak = array();
        $dataJalanMenanjakDariDB = $this->UphillroadModel->getAll();
        foreach ($dataJalanMenanjakDariDB as $row) :
            array_push($dataJalanMenanjak, [$row->id, $row->highest_lat, $row->highest_long, $row->lowest_lat, $row->lowest_long]);
        endforeach;
        $data = [
            'title' => 'Maps',
            'content' => 'vMapsMobile',
            'data_altitude' => $data_coordinat,
            'data_jalan_rusak' => $dataJalanRusak,
            'data_jalan_menanjak' => $dataJalanMenanjak,
        ];


        $this->load->view('TemplateMap/wrapper', $data);
    }

    public function verifikasijalan($token)
    {
        // check is token valid
        $isTokenValid = $this->UsersModel->cekToken($token);
        if ($isTokenValid) {
            $data_coordinat = array();
            $data_altitude = $this->AltitudeModel->getAll();
            foreach ($data_altitude as $row) :
                array_push($data_coordinat, [$row->latitude, $row->longitude, $row->altitude]);
            endforeach;

            $dataJalanRusak = array();
            $dataJalanRusakDariDB = $this->LocationModel->getDataForVerification();
            foreach ($dataJalanRusakDariDB as $row) :
                array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status]);
            endforeach;

            $data = [
                'title' => 'Edit Verifikasi',
                'content' => 'vMapsMobileEditVerifikasi',
                'data_altitude' => $data_coordinat,
                'data_jalan_rusak' => $dataJalanRusak,
                'token' => $token
            ];

            $this->load->view('TemplateMap/wrapper', $data);
        } else {
            redirect("Auth");
        }
    }

    public function demo()
    {
        // check is token valid


        $data_coordinat = array();
        $data_altitude = $this->AltitudeModel->getAll();
        foreach ($data_altitude as $row) :
            array_push($data_coordinat, [$row->latitude, $row->longitude, $row->altitude]);
        endforeach;

        $dataJalanRusak = array();
        $dataJalanRusakDariDB = $this->LocationModel->getDataRusak();
        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status, $row->img_path]);
        endforeach;

        $dataJalanMenanjak = array();
        $dataJalanMenanjakDariDB = $this->UphillroadModel->getAll();
        foreach ($dataJalanMenanjakDariDB as $row) :
            array_push($dataJalanMenanjak, [$row->id, $row->highest_lat, $row->highest_long, $row->lowest_lat, $row->lowest_long]);
        endforeach;
        $data = [
            'title' => 'Maps',
            'content' => 'vMaps',
            'data_altitude' => $data_coordinat,
            'data_jalan_rusak' => $dataJalanRusak,
            'data_jalan_menanjak' => $dataJalanMenanjak,
        ];
        // var_dump($dataJalanRusak[1]);
        // var_dump($dataJalanMenanjak);
        $this->load->view('vDemo', $data);
    }


    public function add()
    {
        $token = $this->input->post("token");
        $isTokenValid = $this->UsersModel->cekToken($token);
        $id_user = $isTokenValid->id;
        if ($isTokenValid) {
            $status = $this->input->post("status");
            $latitude = $this->input->post("latitude");
            $longitude = $this->input->post("longitude");
            $kecamatan = $this->input->post("kecamatan");


            $config['upload_path'] = 'assets/img/datajalan';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 9000;
            $config['max_width'] = 15000;
            $config['max_height'] = 15000;
            $upload_path = $config['upload_path'] . "/" . $_FILES["image_upload"]["name"];
            // $config['file_name'] = "";



            $messageFlash = "";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_upload')) {
                $messageFlash = $this->upload->display_errors();
                // var_dump($error_message);
                $this->session->set_flashdata('msg', "<div class='alert alert-danger fixed-top' role='alert'>$messageFlash</div>");
            } else {
                $metadata = array('image_metadata' => $this->upload->data());
                $messageFlash = "Gambar Berhasil Ditambahkan";
                $this->session->set_flashdata('msg', "<div class='alert alert-success fixed-top' role='alert'>$messageFlash</div>");
            }





            $data = [
                "latitude" => $latitude,
                "longitude" => $longitude,
                "status" => $status,
                "kecamatan" => $kecamatan,
                "update_by" => $id_user,
                "verifikasi" => 1,
                "img_path" => $upload_path
            ];
            // SEPARATE
            $this->LocationModel->add($data);



            redirect('Maps/verifikasijalan/' . $token);
        } else {
            redirect("Auth");
        }
    }


    public function edit()
    {
        $token = $this->input->post("token");
        $isTokenValid = $this->UsersModel->cekToken($token);
        $id_user = $isTokenValid->id;
        if ($isTokenValid) {
            $id_location = $this->input->post("idlocation");
            $status = $this->input->post("status");
            $id_location = explode(",", $id_location);

            $config['upload_path'] = 'assets/img/datajalan';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 9000;
            $config['max_width'] = 15000;
            $config['max_height'] = 15000;
            $upload_path = $config['upload_path'] . "/" . $_FILES["image_upload"]["name"];
            // $config['file_name'] = "";



            $messageFlash = "";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_upload')) {
                $messageFlash = $this->upload->display_errors();
                // var_dump($error_message);
                $this->session->set_flashdata('msg', "<div class='alert alert-danger fixed-top' role='alert'>$messageFlash</div>");
            } else {
                $metadata = array('image_metadata' => $this->upload->data());
                $messageFlash = "Gambar Berhasil Ditambahkan";
                $this->session->set_flashdata('msg', "<div class='alert alert-success fixed-top' role='alert'>$messageFlash</div>");
            }




            // SEPARATE
            $query_condition = "";
            for ($i = 0; $i < count($id_location); $i++) {
                if ($i == count($id_location) - 1) {
                    $query_condition = $query_condition . "id = $id_location[$i]";
                } else {
                    $query_condition = $query_condition . "id = $id_location[$i] OR ";
                }
            }
            $this->db->query("UPDATE location SET update_by = $id_user,status = '$status', verifikasi = 1, img_path = '$upload_path' WHERE $query_condition");



            redirect('Maps/verifikasijalan/' . $token);
        } else {
            redirect("Auth");
        }
    }


    public function titikmenanjak()
    {
        $latitude = $this->input->post("lat");
        $longitude = $this->input->post("lng");
        $posisi = $this->input->post("posisi");
        $token = $this->input->post("token");
        $data_user = $this->UsersModel->cekToken($token);
        $id = $data_user->id;
        $data = [
            "id" => $id
        ];

        if ($posisi == "tertinggi") {

            $newdata = array(
                'highestlat'  => $latitude,
                'highestlng'     => $longitude,
            );
            $this->session->set_flashdata('msgUphill', "<div class='alert alert-success fixed-top' role='alert'>Titik jalan tertinggi sudah diset</div>");
        } else {
            $newdata = array(
                'lowestlat'  => $latitude,
                'lowestlng'     => $longitude,
            );
            $this->session->set_flashdata('msgUphill', "<div class='alert alert-success fixed-top' role='alert'>Titik jalan terendah sudah diset</div>");
        }


        $this->session->set_userdata($newdata);


        if (isset($_SESSION['highestlat']) && isset($_SESSION['lowestlat'])) {
            $data = [
                "id" => $id,
                'highestlat'  => $_SESSION['highestlat'],
                'highestlng'     => $_SESSION['highestlng'],
                'lowestlat'  => $_SESSION['lowestlat'],
                'lowestlng'     => $_SESSION['lowestlng']
            ];
            var_dump($data);
            $this->AltitudeModel->uphill_road($data);
            unset(
                $_SESSION['highestlat'],
                $_SESSION['highestlng'],
                $_SESSION['lowestlat'],
                $_SESSION['loweslng']
            );
            $this->session->set_flashdata('msgUphill', "<div class='alert alert-success fixed-top' role='alert'>Data Jalan Menanjak Berhasil Ditambahkan !</div>");
        }
        redirect("Maps/verifikasijalan/" . $token);
    }



    public function konfirmasiTitikTanjakan()
    {
        $latitude = $this->input->post("lat");
        $longitude = $this->input->post("lng");
        $token = $this->input->post("token");
        $data_user = $this->UsersModel->cekToken($token);
        $id = $data_user->id;
    }
}

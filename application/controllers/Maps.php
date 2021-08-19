<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maps extends CI_Controller
{
    /**
     * Ini adalah consturctor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("UsersModel");
        $this->load->model("LocationModel");
        $this->load->model("UphillroadModel");
    }


    /**
     * Ini adalah method index
     * method index untuk menampilkan template dashboard
     */
    public function index()
    {
        $dataJalanRusak = array();
        $dataJalanRusakDariDB = $this->LocationModel->getDataRusak();

        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->latitude, $row->longitude, $row->status]);
        endforeach;

        $data = [
            'title' => 'Maps',
            'content' => 'vMaps',
            'data_jalan_rusak' => $dataJalanRusak,
        ];

        $this->load->view('templateDashboard/wrapper', $data);
    }


    /**
     * Ini adalah petadigital
     */
    public function petadigital($dataJalan = "")
    {
        $dataJalanRusak = array();
        $dataJalanMenanjak = array();
        $dataJalanMenanjakDariDB = $this->UphillroadModel->getAll();

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


        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status, $row->img_path, $row->verifikasi]);
        endforeach;


        foreach ($dataJalanMenanjakDariDB as $row) :
            array_push($dataJalanMenanjak, [$row->id, $row->highest_lat, $row->highest_long, $row->lowest_lat, $row->lowest_long]);
        endforeach;


        $data = [
            'title' => 'Peta Digital',
            'content' => 'vMapsMobile',
            'data_jalan_rusak' => $dataJalanRusak,
            'data_jalan_menanjak' => $dataJalanMenanjak,
        ];


        return  $this->load->view('TemplateMap/wrapper', $data);
    }


    /**
     * Ini adalah deteksijalan
     */
    public function deteksijalan()
    {
        $dataJalanRusak = array();
        $dataJalanRusakDariDB = $this->LocationModel->getDataRusakTerverifikasi();
        foreach ($dataJalanRusakDariDB as $row) :
            array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status]);
        endforeach;






        $data = [
            'title' => 'Deteksi Jalan Rusak',
            'content' => 'vMapsMobileDeteksiJalanRusak',
            'data_jalan_rusak' => $dataJalanRusak,
            // 'data_jalan_rusak_terverifikasi' => $this->LocationModel->jalan_rusak_terverifikasi(),
        ];

        $this->load->view('TemplateMap/wrapper', $data);
    }



    public function verifikasijalan($token = "", $dataJalan = "true")
    {
        $jenistampildata = $dataJalan;

        $isTokenValid = $this->UsersModel->cekToken($token);
        if ($isTokenValid) {
            if ($jenistampildata == "true" || $jenistampildata = "") {
                //jalan rusak yang akan diverifikasi

                $dataJalanRusakDariDB = $this->LocationModel->getDataForVerification();
            } else {

                // jalan rusak yang sudah diverifikasi dan akan diedit untuk perbaikan
                $dataJalanRusakDariDB = $this->LocationModel->getDataRusakTerverifikasi();
            }


            $dataJalanRusak = array();

            foreach ($dataJalanRusakDariDB as $row) :
                array_push($dataJalanRusak, [$row->id, $row->latitude, $row->longitude, $row->status]);
            endforeach;

            $data = [
                'title' => 'Edit Verifikasi',
                'content' => 'vMapsMobileEditVerifikasi',
                'data_jalan_rusak' => $dataJalanRusak,
                'token' => $token,
                'jenistampildata' => $jenistampildata
            ];
            $this->load->view('TemplateMap/wrapper', $data);
        } else {
            redirect("Auth");
        }
    }




    /**
     * Ini adalah method untuk memproses data add
     */
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
                echo "gagal";
                $messageFlash = $this->upload->display_errors();
                // var_dump($error_message);
                $this->session->set_flashdata('msg', "<div class='alert alert-danger fixed-top' role='alert'>$messageFlash</div>");
            } else {
                echo "berhasil";
                $metadata = array('image_metadata' => $this->upload->data());
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
                $messageFlash = "Berhasil menambahkan jalan rusak";
                $this->session->set_flashdata('msg', "<div class='alert alert-success fixed-top' role='alert'>$messageFlash</div>");
            }
            redirect('Maps/verifikasijalan/' . $token);
        } else {
            redirect("Auth");
        }
    }



    /**
     * Ini adalah method untuk memproses data edit
     */
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


            $query = false;
            $messageFlash = "";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_upload')) {
                $messageFlash = $this->upload->display_errors();
                // var_dump($error_message);
                $this->session->set_flashdata('msg', "<div class='alert alert-danger fixed-top' role='alert'>$messageFlash</div>");
            } else {
                // SEPARATE
                $query_condition = "";
                for ($i = 0; $i < count($id_location); $i++) {
                    if ($i == count($id_location) - 1) {
                        $query_condition = $query_condition . "id = $id_location[$i]";
                    } else {
                        $query_condition = $query_condition . "id = $id_location[$i] OR ";
                    }
                }
                $query = $this->db->query("UPDATE location SET update_by = $id_user,status = '$status', verifikasi = 1, img_path = '$upload_path', date = '$this->currentDateTime' WHERE $query_condition");
                $metadata = array('image_metadata' => $this->upload->data());
                $messageFlash = "Berhasil memperbaharui status dan verifikasi jalan";
            }


            if ($query) {
                $this->session->set_flashdata('msg', "<div class='alert alert-success fixed-top' role='alert'>$messageFlash</div>");
                redirect('Maps/verifikasijalan/' . $token . "/true");
            } else {
                $this->session->set_flashdata('msg', "<div class='alert alert-danger fixed-top' role='alert'>Status dan verifikasi jalan gagal diperbaharui</div>");
            }
        } else {
            redirect("Auth");
        }
    }



    /**
     * Ini adalah method untuk memproses data titik jalan menanjak
     */
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
            $this->UphillroadModel->uphill_road($data);
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


    /**
     * Ini DEMO< BUKAN UNTUK PRODUCTION
     */
    // DEMO BUKAN UNTUK PRODUCTIONS
    public function demo()
    {
        // check is token valid
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
            'data_jalan_rusak' => $dataJalanRusak,
            'data_jalan_menanjak' => $dataJalanMenanjak,
        ];
        $this->load->view('vDemo', $data);
    }
}

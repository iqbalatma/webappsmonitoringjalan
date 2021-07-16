<?php

defined('BASEPATH') or exit('No direct script access allowed');


class LocationModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table      = 'location';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';


    public function getAll()
    {
        return $this->db->query("SELECT * FROM location")->result();
    }

    public function getDataRusak()
    {
        return $this->db->query("SELECT * FROM location WHERE status = 'Rusak'")->result();
    }
    public function getDataRusakTerverifikasi()
    {
        return $this->db->query("SELECT * FROM location WHERE status = 'Rusak' AND verifikasi =1")->result();
    }

    public function getDataForVerification()
    {
        return $this->db->query("SELECT * FROM location WHERE status ='Rusak' AND verifikasi = 0")->result();
    }

    public function getDinamisQuery($query)
    {
        return $this->db->query($query)->result();
    }




    public function add($data)
    {
        $this->db->insert($this->table, $data);
    }



    public function saveAcc($data)
    {
        $latitude = doubleval($data["latitude"]);
        $longitude = doubleval($data["longitude"]);
        $cek_lokasi = $this->db->query("SELECT * FROM location where latitude = $latitude AND longitude = $longitude")->result_array();
        if ($cek_lokasi) {
            //lat long ada tapi tidak rusak
            $id_location = $cek_lokasi[0]["id"];
            $status = $cek_lokasi[0]["status"];
            if ($status == 'Tidak Rusak') {
                $cek_lokasi = $this->db->query("UPDATE location SET status= 'Rusak' WHERE id = $id_location")->result_array();
            }
        } else {
            $data_location = [
                "id" => "",
                "latitude" => doubleval($data["latitude"]),
                "longitude" => doubleval($data["longitude"]),
                "status" => "Rusak",
                "verifikasi" => 0,
                "kecamatan" => $data["kecamatan"]
            ];
            $this->db->insert($this->table, $data_location);
        }
    }

    public function getLastLocaton()
    {
        return $this->db->query("SELECT * FROM location ORDER BY id DESC LIMIT 1")->result_array();
    }


    // BELUM DIGUNAKAN

    // public function update()
    // {
    //     // $post = $this->input->post();
    //     // $this->product_id = $post["id"];
    //     // $this->name = $post["name"];
    //     // $this->price = $post["price"];
    //     // $this->description = $post["description"];
    //     // return $this->db->update($this->_table, $this, array('product_id' => $post['id']));
    // }

    // public function delete($id)
    // {
    //     // return $this->db->delete($this->_table, array("product_id" => $id));
    // }
}

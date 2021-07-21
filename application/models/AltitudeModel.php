<?php

defined('BASEPATH') or exit('No direct script access allowed');


class AltitudeModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table      = 'altitude';
    protected $table_location = 'location';
    protected $table_device_info = 'device_info';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';


    public function getAll()
    {
        return $this->db->query("SELECT altitude.id, altitude.altitude, altitude.date, location.latitude, location.longitude, location.kecamatan, device_info.android_id, device_info.id as device_id FROM altitude INNER JOIN location ON altitude.location_id = location.id INNER JOIN device_info ON altitude.device_id = device_info.id")->result();
    }

    public function getById($id)
    {
        return $this->db->query("SELECT altitude.id, altitude.altitude, altitude.date, location.latitude, location.longitude, location.kecamatan FROM altitude INNER JOIN location ON altitude.location_id = location.id WHERE altitude.id = $id")->result();
    }




    public function save($data)
    {
        $latitude = $data["latitude"];
        $longitude = $data["longitude"];
        $android_id = $data["android_id"];

        $cek_android_id = $this->db->query("SELECT * FROM device_info where android_id = '$android_id'")->result_array();

        if ($cek_android_id) {
            $android_primary_key = $cek_android_id[0]["id"];
        } else {
            $data_device_info = [
                "id" => "",
                "android_id" => $android_id
            ];
            $this->db->insert($this->table_device_info, $data_device_info);
            $android_primary_key = $this->getLastDeviceSurveyor();
            $android_primary_key = $android_primary_key[0]["id"];
        }

        $cek_lokasi = $this->db->query("SELECT * FROM location where latitude = $latitude AND longitude = $longitude")->result_array();

        //data lokasi ada, langsung insertkan id lokasi
        if ($cek_lokasi) {
            $id_location = $cek_lokasi[0]["id"];
            $data_altitude = [
                "id" => "",
                "altitude" => doubleval($data['altitude']),
                "device_id" => $android_primary_key,
                "location_id" => $id_location,

            ];
            $this->db->insert($this->table, $data_altitude);
        }
        //data lokasi tidak ada, buat lokasi baru
        else {
            $data_location = [
                "id" => "",
                "latitude" => doubleval($data["latitude"]),
                "longitude" => doubleval($data["longitude"]),
                "status" => "Tidak Rusak",
                "verifikasi" => 0,
                "kecamatan" => $data["kecamatan"]
            ];
            $this->db->insert($this->table_location, $data_location);

            $data_location  = $this->getLastLocaton();
            $id_location = $data_location[0]['id'];
            $data_altitude = [
                "id" => "",
                "altitude" => doubleval($data['altitude']),
                "device_id" => $android_primary_key,
                "location_id" => $id_location,

            ];
            $this->db->insert($this->table, $data_altitude);
        }
    }

    public function getLastLocaton()
    {
        return $this->db->query("SELECT * FROM location ORDER BY id DESC LIMIT 1")->result_array();
    }

    public function getLastDeviceSurveyor()
    {
        return $this->db->query("SELECT * FROM device_info ORDER BY id DESC LIMIT 1")->result_array();
    }

    public function uphill_road($data)
    {
        $data_uphill_road = [
            "highest_lat" => $data['highestlat'],
            "highest_long" => $data['highestlng'],
            "lowest_lat" => $data['lowestlat'],
            "lowest_long" => $data['lowestlng'],
            "update_by" => $data['id']
        ];
        $this->db->insert("uphill_road", $data_uphill_road);
    }


    // BELUM DIGUNAKAN

    public function update()
    {
        // $post = $this->input->post();
        // $this->product_id = $post["id"];
        // $this->name = $post["name"];
        // $this->price = $post["price"];
        // $this->description = $post["description"];
        // return $this->db->update($this->_table, $this, array('product_id' => $post['id']));
    }

    public function delete($id)
    {
        // return $this->db->delete($this->_table, array("product_id" => $id));
    }
}

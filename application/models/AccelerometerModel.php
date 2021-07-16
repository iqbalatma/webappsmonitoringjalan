<?php

defined('BASEPATH') or exit('No direct script access allowed');


class AccelerometerModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table      = 'accelerometer';
    protected $table_location = 'location';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';


    public function getAll()
    {
        return $this->db->query("SELECT * FROM accelerometer INNER JOIN location ON accelerometer.location_id = location.id")->result();
    }

    public function getById($id)
    {
        return $this->db->query("SELECT * FROM accelerometer INNER JOIN location ON accelerometer.location_id = location.id WHERE accelerometer.id = $id")->result();
    }







    public function save($data)
    {
        $latitude = doubleval($data["latitude"]);
        $longitude = doubleval($data["longitude"]);
        $cek_lokasi = $this->db->query("SELECT * FROM location where latitude = $latitude AND longitude = $longitude")->result_array();


        if ($cek_lokasi) {
            $id_location = $cek_lokasi[0]["id"];
            $data_accelerometer = [
                "id" => "",
                "x_axis" => doubleval($data['x_axis']),
                "y_axis" => doubleval($data['y_axis']),
                "z_axis" => doubleval($data['z_axis']),
                "status" => $data['status'],
                "location_id" => $id_location,

            ];
            $this->db->insert($this->table, $data_accelerometer);
        } else {
            $data_location = [
                "id" => "",
                "latitude" => doubleval($data["latitude"]),
                "longitude" => doubleval($data["longitude"]),
                "kecamatan" => $data["kecamatan"]
            ];
            $this->db->insert($this->table_location, $data_location);
            $id_location = 25;
            $data_location  = $this->getLastLocaton();
            $id_location = $data_location[0]['id'];
            $data_accelerometer = [
                "id" => "",
                "x_axis" => doubleval($data['x_axis']),
                "y_axis" => doubleval($data['y_axis']),
                "z_axis" => doubleval($data['z_axis']),
                "status" => $data['status'],
                "location_id" => $id_location,

            ];

            $this->db->insert($this->table, $data_accelerometer);
        }
    }

    public function getLastLocaton()
    {
        return $this->db->query("SELECT * FROM location ORDER BY id DESC LIMIT 1")->result_array();
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

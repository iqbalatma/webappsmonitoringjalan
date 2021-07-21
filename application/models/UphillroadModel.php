<?php

defined('BASEPATH') or exit('No direct script access allowed');


class UphillroadModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table      = 'uphill_road';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';


    public function getAll()
    {
        return $this->db->query("SELECT * FROM uphill_road")->result();
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
}

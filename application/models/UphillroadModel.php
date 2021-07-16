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
}

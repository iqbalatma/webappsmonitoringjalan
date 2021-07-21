<?php

defined('BASEPATH') or exit('No direct script access allowed');





class UsersModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';


    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    public function getByUsername($username)
    {
        return $this->db->get_where($this->table, ["username" => $username])->row();
    }

    public function cekToken($token)
    {
        return $this->db->get_where($this->table, ["token" => "$token"])->row();
    }






    // BELUM DIGUNAKAN
    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update()
    {
    }

    public function delete($id)
    {
    }
}

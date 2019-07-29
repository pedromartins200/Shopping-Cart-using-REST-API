<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Countries_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCountries()
    {
        $query = "SELECT * FROM countries;";
        $q = $this->db->query($query);
        return $q->result();
    }

}
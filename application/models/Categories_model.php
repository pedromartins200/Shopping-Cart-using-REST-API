<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories;";
        $q = $this->db->query($query);
        return $q->result();
    }

}
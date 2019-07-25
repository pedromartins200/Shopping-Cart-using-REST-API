<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products;";
        $q = $this->db->query($query);
        return $q->result();
    }

    public function getProducts($category_id)
    {
        $query = "SELECT * FROM products WHERE cat_id = ?";
        $q = $this->db->query($query,array($category_id));
        return $q->result();
    }

    public function getProduct($product_id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $q = $this->db->query($query,array($product_id));
        return $q->result();
    }


}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show_my_orders($customer_id) {
        $sql = "SELECT * FROM orders WHERE customer_id = ?;";
        $query = $this->db->query($sql, array($customer_id));
        return $query->result_array();
    }

    public function show_my_order_items($order_id) {
        $sql = "SELECT products.*,order_items.quantity,categories.name AS category_name FROM products
                INNER JOIN order_items ON products.id = order_items.product_id 
                INNER JOIN categories ON categories.id = products.cat_id
                INNER JOIN orders ON orders.id = order_items.order_id AND orders.id = ?";
        $query = $this->db->query($sql, array($order_id));
        return $query->result_array();
    }


}
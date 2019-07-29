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

    public function insert_order($total_price, $customer_id, $voucher_id, $shipping_address, $voucher_discount) {
        $status = 1;
        $created_at = date("Y-m-d H:i:s");
        $sql = "INSERT INTO orders (customer_id,created_at,status,total, voucher, shipping_address, voucher_discount) VALUES (?,?,?,?,?,?,?);";
        $query = $this->db->query($sql, array($customer_id, $created_at,$status, $total_price, $voucher_id, $shipping_address, $voucher_discount));
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_order_items($order_id,$array_items) {
        foreach($array_items as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?,?,?);";
            $query = $this->db->query($sql, array($order_id, $product_id, $quantity));
        }
    }


}
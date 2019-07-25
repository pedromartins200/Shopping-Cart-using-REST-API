<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCart($user_id)
    {
        //aggregate query para juntar quantidades e produtos
        $query = "SELECT products.*, SUM(cart_items.quantity) as 'quantity', categories.name as 'cat_name', customers.api_key as 'api_key' FROM `cart_items` INNER JOIN products ON products.id = cart_items.product_id INNER JOIN categories ON categories.id = products.cat_id INNER JOIN customers ON customers.id = cart_items.user_id AND cart_items.user_id = ? GROUP BY cart_id, user_id, product_id, quantity";
        $q = $this->db->query($query, array($user_id));
        return $q->result_array();
    }

    public function get_products($book_id) {
        $sql = "SELECT products.id AS 'products.id', products.cat_id, products.name AS 'products.name', products.description, products.price, products.image, categories.name AS 'categories.name' FROM products INNER JOIN categories ON categories.id = products.cat_id AND products.id='$book_id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function checkUserCart($user_id)
    {
        $sql = "SELECT * FROM cart WHERE user_id = ?;";
        $query = $this->db->query($sql, array($user_id));

        if($query->num_rows() > 0) {
            return true;
        }

        return false;
    }

    public function cartItems($user_id)
    {
        $sql = "SELECT * FROM cart_items WHERE user_id = ?;";
        $query = $this->db->query($sql, array($user_id));
        return $query->result_array();
    }

    public function getUserCart($user_id)
    {
        $sql = "SELECT * FROM cart WHERE user_id = ?;";
        $query = $this->db->query($sql, array($user_id));
        return $query->result_array();
    }

    public function deleteCart($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('cart_items');
    }

    public function deleteCartItem($user_id, $product_id)
    {
        $this->db->where('user_id', $user_id)->where('product_id', $product_id);
        $this->db->delete('cart_items');
    }

    public function updateCartItem($user_id, $product_id, $quantity)
    {
        $this->db->set('quantity', $quantity);
        $this->db->where('user_id', $user_id)->where('product_id', $product_id);
        $this->db->update('cart_items');
    }

    public function insertItem($cart_id, $user_id, $product_id, $quantity)
    {
        $cart_items = $this->cartItems($user_id);
        //encontrar cart items com este item.
        //Se ja existir, apenas atualizamos a quantidade
        //Para nao ter 3 vezes o mesmo item na tabela... assim fica 1 item com quantidade 3
        if(count($cart_items) > 0) {

            foreach($cart_items as $item)
            {
                //encontrei este item na lista do cart
                //atualizar quantidade
                if($product_id == $item['product_id'])
                {
                    $this->db->set('quantity', $item['quantity'] + $quantity);
                    $this->db->where('user_id', $user_id);
                    $this->db->where('product_id', $product_id);
                    $this->db->update('cart_items');
                    return;
                }
            }
            //nao encontrei o item no cart, adicionar
            $item = array(
                'cart_id' => $cart_id,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            );

            $this->db->insert('cart_items', $item);
        } else {
            //cart nao tem item, entao adicionar este primeiro item
            $item = array(
                'cart_id' => $cart_id,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            );

            $this->db->insert('cart_items', $item);
        }


    }



}
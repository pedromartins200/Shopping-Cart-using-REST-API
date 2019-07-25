<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function cart_item_insert()
    {
        $this->load->model('cart_model');
        //escape, xss_clean
        $post = $this->input->post(null, true);

        $session_data = $this->session->userdata('logged_in');

        //Entao significa que nao usamos codigo do cliente, mas sim a API
        if(isset($session_data))
        {
            $client = new GuzzleHttp\Client();
            try {
                $cart = $client->request('POST', 'http://localhost/challenge/api/Cart/', [
                    'auth' => ['admin', '1234'],
                    'form_params' => [
                        'product_id' => $post['product_id'],
                        'quantity' => $post['quantity'],
                        'user_id' => $session_data['id'],
                        'api_key' => $session_data['api_key']
                    ]
                ]);
            }  catch (GuzzleHttp\Exception\ClientException $e) {
                echo $e->getMessage();
            }


        } else {
            if (!empty($post['quantity'])) {
                if (!is_numeric($post['quantity'])) {
                    redirect('/home');
                }
                $book_id = $post['product_id'];

                $post['quantity'] = intval($post['quantity']);

                $productByCode = $this->cart_model->get_products($book_id);
                $itemArray = array('a' . $productByCode[0]["products.id"] => array('id' => $productByCode[0]["products.id"], 'name' => $productByCode[0]['products.name'],
                    'cat_name' => $productByCode[0]["categories.name"], 'quantity' => $post['quantity'], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));


                $session_cart = $_SESSION['cart'];

                if (!empty($_SESSION['cart'])) {
                    if (in_array($productByCode[0]["products.id"], array_keys($session_cart)) && $this->check($productByCode[0]["products.id"], $session_cart)) {
                        foreach ($session_cart as $k => $v) {
                            if ($productByCode[0]["products.id"] == $k) {

                                if (empty($session_cart[$k]["quantity"])) {
                                    $session_cart[$k]["quantity"] = 0;
                                }


                                $session_cart[$k]["quantity"] += $post['quantity'];


                            }
                        }
                    } else {
                        //echo "ok";
                        $session_cart = array_merge($session_cart, $itemArray);
                    }
                } else {
                    $session_cart = $itemArray;
                }
            }


            //REMOVER DUPLICADOS E ADICIONAR QUANTIDADE
            $result = array_values(array_reduce($session_cart, function ($result, $entry) {
                if (isset($result[$entry['id']])) {
                    $result[$entry['id']]['quantity'] += $entry['quantity'];
                } else {
                    $result[$entry['id']] = $entry;
                }
                return $result;
            }, []));

            $session_cart = $result;

            //ORDENAR POR ID NO CARRINHO
            usort($session_cart, function ($a, $b) {
                return $a['id'] > $b['id'];
            });

            $_SESSION['cart'] = $session_cart;

            $this->updateDatabaseCart();

        }
        redirect('/home');

    }

    public function remove_from_cart($item_id)
    {

        $session_data = $this->session->userdata('logged_in');

        //Entao significa que nao usamos codigo do cliente, mas sim a API
        if(isset($session_data)) {
            $client = new GuzzleHttp\Client();
            try {
                $cart = $client->request('DELETE', 'http://localhost/challenge/api/Cart/'.$session_data['id'].'/'.$session_data['api_key'].'/'.$item_id, [
                    'auth' => ['admin', '1234']
                ]);
            }  catch (GuzzleHttp\Exception\ClientException $e) {
                $this->tools->_debug($e);
            }
        }

        else {
            //$id_cat = $_SESSION['categoryID'];
            if (!empty($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $k => $v) {
                    //echo $item_id . " ". $k;
                    if ($item_id == $_SESSION["cart"][$k]['id']) {
                        unset($_SESSION["cart"][$k]);
                    }
                    if (empty($_SESSION["cart"]))
                        unset($_SESSION["cart"]);
                }
            }

        }
        redirect('/home');
    }


    public function empty_cart() {

        $session_data = $this->session->userdata('logged_in');

        //Entao significa que nao usamos codigo do cliente, mas sim a API
        if(isset($session_data)) {
            $client = new GuzzleHttp\Client();
            try {
                $cart = $client->request('DELETE', 'http://localhost/challenge/api/Cart/'.$session_data['id'].'/'.$session_data['api_key'], [
                    'auth' => ['admin', '1234']
                ]);
            }  catch (GuzzleHttp\Exception\ClientException $e) {
                $this->tools->_debug($e);
            }
        } else {
            $result = 0;
            foreach($_SESSION["cart"] as $item) {
                $result += $item["quantity"];
            }
            unset($_SESSION["cart"]);
        }
        redirect('/home');
    }


    public function updateCart()
    {
        $this->load->model('cart_model');
        $post = $this->input->post(null,true);

        $session_data = $this->session->userdata('logged_in');

        //Entao significa que nao usamos codigo do cliente, mas sim a API
        if(isset($session_data))
        {

            if($post['quantity'] <= 0) {
                $post['quantity'] = 1;
            }

            $client = new GuzzleHttp\Client();
            try {
                $cart = $client->request('PATCH', 'http://localhost/challenge/api/Cart/'.$session_data['id'].'/'.$session_data['api_key'].'/'.$post['id'].'/'.$post['quantity'], [
                    'auth' => ['admin', '1234']
                ]);
            }  catch (GuzzleHttp\Exception\ClientException $e) {
                echo $e->getMessage();
            }

        } else {
            if(!empty($post)) {
                $item_id = $post['id'];
                $item_quantity = $post['quantity'];
                if ($item_id && $item_quantity && is_numeric($item_quantity)) {
                    $item_quantity = intval($item_quantity);
                    $productByCode = $this->cart_model->get_products($item_id);
                    $itemArray = array($productByCode[0]["products.id"] => array('id' => $productByCode[0]["products.id"], 'name' => $productByCode[0]['products.name'], 'cat_name' => $productByCode[0]["categories.name"], 'quantity' => $item_quantity, 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));
                    if (in_array($productByCode[0]["products.id"], array_keys($_SESSION["cart"])) && $this->check($productByCode[0]["products.id"], $_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $k => $v) {
                            if ($productByCode[0]["products.id"] == $k) {
                                $_SESSION["cart"][$k]["quantity"] = $item_quantity;
                                //$_SESSION["K"] = $_SESSION["cart_item"][2];

                            }
                        }
                    } else {
                        $_SESSION["cart"] = array_merge($_SESSION["cart"], $itemArray);
                    }

                    $result = array_values(array_reduce($_SESSION["cart"], function ($result, $entry) {
                        if (isset($result[$entry['id']])) {
                            $result[$entry['id']]['quantity'] = $entry['quantity'];
                        } else {
                            $result[$entry['id']] = $entry;
                        }
                        return $result;
                    }, []));

                    $_SESSION["cart"] = $result;
                    usort($_SESSION["cart"], function ($a, $b) {
                        return $a['id'] > $b['id'];
                    });

                }
            }
        }
        redirect('/home');
    }


    public function check($id, $array)
    {
        $result = false;
        foreach ($array as $item) {
            if ($item['id'] == $id) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    /*
        private function updateDatabaseCart()
        {
            $session_data = $this->session->userdata('logged_in');
            if(isset($session_data)) {

                $user_cart = $this->cart_model->getUserCart($session_data['id']);

                //Eliminar tudo o que estava antes na BD
                $this->db->where('user_id', $session_data['id']);
                $this->db->delete('cart_items');

                //Substituir
                foreach ($_SESSION['cart'] as $item) {
                    $cart_items = array(
                        'cart_id' => $user_cart[0]['cart_id'],
                        'user_id' => $session_data['id'],
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price_per_product' => $item['price']
                    );
                    $this->db->insert('cart_items', $cart_items);
                }
            }
        }
    */
}
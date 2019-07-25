<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

defined('BASEPATH') OR exit('No direct script access allowed');


// este controller serve para fazer load do header e footer automaticamente
// entre outras coisas...
class MY_Controller extends CI_Controller
{
    protected $data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('cart_model');
    }

    protected function render($the_view = NULL, $template = 'public')
    {
        //verifica se existe login
        $session_data = $this->session->userdata('logged_in');
        if(isset($session_data)) {
            $this->data['logged_in'] = "1";
            $this->data['user_name'] = $session_data['name'];
            $this->data['api_key'] = $session_data['api_key'];
        } else {
            $this->data['logged_in'] = "0";
        }

        //load cart info
        $this->pre_load_cart($session_data);

        if($template == 'json' || $this->input->is_ajax_request())
        {
            header('Content-Type: application/json');
            echo json_encode($this->data);
        }
        elseif(is_null($template))
        {
            $this->load->view($the_view,$this->data);
        }
        else
        {
            $this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view('templates/' . $the_view,$this->data, TRUE);;
            $content = $this->load->view('templates/' . $template, $this->data);
        }

        //$this->tools->_debug($this->data);exit;

        return $content;
    }


    private function pre_load_cart($session_data)
    {

        //Determinar o que esta no carrinho, preço e quantidade
        $total_quantity = 0;
        $total_price = 0;


        if($this->data['logged_in'] == "1") {
            $client = new GuzzleHttp\Client();
            //$this->tools->_debug($session_data);exit;
            try {
                $session_cart = $client->request('GET', 'http://localhost/challenge/api/Cart/' . $session_data['id'] . '/' . $session_data['api_key'], [
                    'auth' => ['admin', '1234']
                ]);
            }  catch (GuzzleHttp\Exception\ServerException $e) {
                echo $e->getMessage();
            }

            $this->data['cart'] = json_decode($session_cart->getBody()->getContents(), true);

            //para evitar o bug de nao existir session
            $_SESSION['cart'] = $this->data['cart'];

            foreach($this->data['cart'] as $item) {
                $total_quantity += $item['quantity'];
                $total_price += ($item['price']*$item['quantity']);
            }
        } else {
            if(isset($_SESSION['cart'])) {
                $session_cart = $_SESSION['cart'];
                $this->data['cart'] = $session_cart;
                foreach($session_cart as $item) {
                    $total_quantity += $item['quantity'];
                    $total_price += ($item['price']*$item['quantity']);
                }
            }
        }

        $this->data['total_cart_quantity'] = $total_quantity;
        $this->data['total_price'] = $total_price;
    }
}


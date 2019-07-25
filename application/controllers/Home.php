<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(E_ERROR | E_PARSE);

class Home extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Pagina inicial. Mostra as categorias e produtos.
     * @param bool $category_id
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index($category_id = FALSE)
    {
        $client = new GuzzleHttp\Client();
        //Obter todos os produtos dependendo da categoria
        //Se nao houver categoria, mostrar todos
        if (isset($category_id)) {
            $products_list = $client->request('GET', 'http://localhost/challenge/api/Products/' . $category_id, [
                'auth' => ['admin', '1234']
            ]);

        } else {
            $products_list = $client->request('GET', 'http://localhost/challenge/api/Products/', [
                'auth' => ['admin', '1234']
            ]);
        }

        //Listar todas as categorias
        $categories_list = $client->request('GET', 'http://localhost/challenge/api/Categories/', [
            'auth' => ['admin', '1234']
        ]);

        $categories = $categories_list->getBody()->getContents();

        $this->data['categories'] = json_decode($categories, true);
        $this->data['category_id'] = isset($category_id) ? $category_id : 0;


        $products = $products_list->getBody()->getContents();

        $this->data['products'] = json_decode($products, true);


        if(!empty($this->session->get_userdata('cart_item')))
        {
            $this->data['cart_item_info'] = $this->session->get_userdata('cart_item');
            $this->session->unset_userdata('cart_item');
        }

        $this->render('home');
    }

    public function addItemCart()
    {
        $client = new GuzzleHttp\Client();
        $post = $this->input->post(null, true);

        $product_id = $post['product_id'];

        $quantity = $post['quantity'];

        $this->form_validation->set_rules('quantity', 'Quantity field', 'numeric');

        if($this->form_validation->run() == false) {
            $this->session->set_userdata('cart_item', 'Quantity of the product must be numeric');
            redirect('/home');
        } else {
            try {
                $cart = $client->request('POST', 'http://localhost/challenge/api/Cart/', [
                    'auth' => ['admin', '1234'],
                    'form_params' => [
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ]
                ]);
            }  catch (GuzzleHttp\Exception\ClientException $e) {
                echo $e->getMessage();
            }


            $this->session->set_userdata('cart_item', $quantity.' item/s added to cart');
            redirect('/home');
        }

    }
}
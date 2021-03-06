<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $post = $this->input->post(null,true);


        $session_data = $this->session->userdata('logged_in');

        if(!isset($session_data))
        {
            redirect('/home');
        }

        if(!empty($post))
        {
            $client = new GuzzleHttp\Client();
            //$this->tools->_debug($post);exit;
            //$this->tools->_debug($session_data);exit;


            //se o post for para criar fiscal info
            if(isset($post['nif_fiscal_info'])) {
                $this->form_validation->set_rules('name_fiscal_info', 'Name of fiscal invoice', 'required');
                $this->form_validation->set_rules('nif_fiscal_info', 'Nif of fiscal invoice', 'required');
                $this->form_validation->set_rules('city_fiscal_info', 'City of fiscal invoice', 'required');
                $this->form_validation->set_rules('address_fiscal_info', 'Address of fiscal invoice', 'required');
                $this->form_validation->set_rules('zipcode_fiscal_info', 'zipcode_fiscal_info', 'required');
                $this->form_validation->set_rules('customer_id', 'Id of customer', 'required');

                if($this->form_validation->run() == FALSE)
                {
                    $this->render('order');
                } else {
                    $client = new GuzzleHttp\Client();

                    try {
                        $fiscal_invoice = $client->request('POST', 'http://localhost/challenge/api/Fiscal/', [
                            'auth' => ['admin', '1234'],
                            'form_params' => [
                                'nif_fiscal_info' => $post['nif_fiscal_info'],
                                'name_fiscal_info' => $post['name_fiscal_info'],
                                'address_fiscal_info' => $post['address_fiscal_info'],
                                'city_fiscal_info' => $post['city_fiscal_info'],
                                'zipcode_fiscal_info' => $post['zipcode_fiscal_info'],
                                'country_fiscal_info' => $post['country_fiscal_info'],
                                'customer_id' => $post['customer_id'],
                                'user_id' => $session_data['id'],
                                'api_key' => $session_data['api_key']
                            ]
                        ]);
                    } catch (GuzzleHttp\Exception\ClientException $e) {
                        echo $e->getMessage();
                    }
                }
            }


            try {

                if(!empty($post['voucher'])) {
                    $session_cart = $client->request('GET', 'http://localhost/challenge/api/Cart/' . $session_data['id'] . '/' . $session_data['api_key'] . '/' . $post['voucher'], [
                        'auth' => ['admin', '1234']
                    ]);
                } else {
                    $session_cart = $client->request('GET', 'http://localhost/challenge/api/Cart/' . $session_data['id'] . '/' . $session_data['api_key'], [
                        'auth' => ['admin', '1234']
                    ]);
                }

                $fiscal_info = $client->request('GET', 'http://localhost/challenge/api/Fiscal/' . $session_data['id'] . '/' . $session_data['api_key'] , [
                    'auth' => ['admin', '1234']
                ]);

                $countries = $client->request('GET', 'http://localhost/challenge/api/Misc/'.'countries', [
                    'auth' => ['admin', '1234']
                ]);


            }  catch (GuzzleHttp\Exception\ServerException $e) {
                echo $e->getMessage();
            }

            $result = json_decode($session_cart->getBody()->getContents(), true);

            $this->data['cart'] = $result['cart'];

            $this->data['countries'] = json_decode($countries->getBody()->getContents(), true);

            if(!empty($post['voucher']) && $result['voucher_exists'] == "1") {
                $this->data['discount_price'] = $result['discount_price'];
                $this->data['voucher_id'] = $result['voucher_id'];
            }

            $this->data['fiscal_info'] = json_decode($fiscal_info->getBody()->getContents(), true);

            $this->data['customer_id'] = $session_data['id'];

            //Because this variable could get lost when creating new fiscal info
            $this->data['voucher'] = $post['voucher'];

            $this->render('order');
        }
    }


    public function order_action()
    {
        $post = $this->input->post(null,true);

        if(!empty($post))
        {
            if(isset($post['voucher_id'])) {
                $this->form_validation->set_rules('voucher_id', 'Voucher ID', 'required');
            }
            $this->form_validation->set_rules('shipping_address', 'Shipping address', 'required');
            $this->form_validation->set_rules('customer_fiscal_id', 'Invoice address', 'required');



            if($this->form_validation->run() == FALSE) {
                $this->render('order');
            } else {
                $client = new GuzzleHttp\Client();

                try {

                    //we will get cart content directly inside the API
                    //In other words, we are not passing the content of the cart here
                    $session_data = $this->session->userdata('logged_in');

                    if(!isset($post['voucher_id']))
                    {

                        $order = $client->request('POST', 'http://localhost/challenge/api/Order/', [
                            'auth' => ['admin', '1234'],
                            'form_params' => [
                                'shipping_address' => $post['shipping_address'],
                                'customer_fiscal_id' => $post['customer_fiscal_id'],
                                'user_id' => $session_data['id'],
                                'api_key' => $session_data['api_key']
                            ]
                        ]);
                    } else {

                        $order = $client->request('POST', 'http://localhost/challenge/api/Order/', [
                            'auth' => ['admin', '1234'],
                            'form_params' => [
                                'voucher_id' => $post['voucher_id'],
                                'shipping_address' => $post['shipping_address'],
                                'customer_fiscal_id' => $post['customer_fiscal_id'],
                                'user_id' => $session_data['id'],
                                'api_key' => $session_data['api_key']
                            ]
                        ]);
                    }

                }  catch (GuzzleHttp\Exception\ClientException $e) {
                    echo $e->getMessage();
                }

                $this->render('order_sucess');
            }
        }
    }

    public function create_fiscal_info()
    {
        $post = $this->input->post(null,true);


        $session_data = $this->session->userdata('logged_in');


        if(!empty($post)) {

            $this->form_validation->set_rules('name_fiscal_info', 'Name of fiscal invoice', 'required');
            $this->form_validation->set_rules('nif_fiscal_info', 'Nif of fiscal invoice', 'required');
            $this->form_validation->set_rules('city_fiscal_info', 'City of fiscal invoice', 'required');
            $this->form_validation->set_rules('address_fiscal_info', 'Address of fiscal invoice', 'required');
            $this->form_validation->set_rules('zipcode_fiscal_info', 'zipcode_fiscal_info', 'required');
            $this->form_validation->set_rules('customer_id', 'Id of customer', 'required');

            if($this->form_validation->run() == FALSE)
            {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $client = new GuzzleHttp\Client();

                try {
                    $fiscal_invoice = $client->request('POST', 'http://localhost/challenge/api/Fiscal/', [
                        'auth' => ['admin', '1234'],
                        'form_params' => [
                            'nif_fiscal_info' => $post['nif_fiscal_info'],
                            'name_fiscal_info' => $post['name_fiscal_info'],
                            'address_fiscal_info' => $post['address_fiscal_info'],
                            'city_fiscal_info' => $post['city_fiscal_info'],
                            'zipcode_fiscal_info' => $post['zipcode_fiscal_info'],
                            'customer_id' => $post['customer_id'],
                            'user_id' => $session_data['id'],
                            'api_key' => $session_data['api_key']
                        ]
                    ]);
                } catch (GuzzleHttp\Exception\ClientException $e) {
                    echo $e->getMessage();
                }
                redirect($_SERVER['HTTP_REFERER']);
            }


        }
        redirect('/home');
    }
}


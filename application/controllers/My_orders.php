<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;


defined('BASEPATH') OR exit('No direct script access allowed');

class My_orders extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $session_data = $this->session->userdata('logged_in');

        if (!isset($session_data)) {
            redirect('/home');
        }

        $client = new GuzzleHttp\Client();

        try {
            $orders = $client->request('GET', 'http://localhost/challenge/api/Order/' . $session_data['id'] . '/' . $session_data['api_key'], [
                'auth' => ['admin', '1234']
            ]);

        } catch (GuzzleHttp\Exception\ServerException $e) {
            echo $e->getMessage();
        }

        $this->data['orders'] = json_decode($orders->getBody()->getContents(), true);


        $this->render('my_orders');
    }
}

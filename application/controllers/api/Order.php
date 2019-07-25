<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Order extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Obtem as orders deste user, com os respetivos order items
     */
    public function index_get($user_id, $api_key)
    {
        $this->load->model('cart_model');

        $data = array();

        $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }


    /**
     * Cria uma order com o que esta no carrinho
     * Opçao de discount voucher
     */
    public function index_post($voucher_key = FALSE)
    {
        $this->load->model('cart_model');
        $this->load->model('vouchers_model');

        $voucher = $this->vouchers_model->getVoucher($voucher_key);

        if(!empty($voucher))
        {
            $total_price = $total_price * $voucher['discount_percentage'];
        }

        $post = $this->input->post(null,true);

    }
}
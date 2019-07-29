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
     * Se order_id esta set, mostra os order items desta order
     */
    public function index_get($user_id, $api_key, $order_id = FALSE)
    {
        $this->load->model('orders_model');
        $this->load->model('customers_model');


        $user = $this->customers_model->checkApiKey($user_id, $api_key);

        if($user) {

            if(!$order_id == FALSE) {

                $data = $this->orders_model->show_my_order_items($order_id);

            } else {

                $data = $this->orders_model->show_my_orders($user_id);
            }


            $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response('Unauthorized request', \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }


    }


    /**
     * Cria uma order com o que esta no carrinho
     * Opçao de discount voucher
     */
    public function index_post()
    {
        $this->load->model('cart_model');
        $this->load->model('vouchers_model');
        $this->load->model('customer_fiscal_model');
        $this->load->model('customers_model');
        $this->load->model('orders_model');

        $post = $this->input->post(null, true);

        $user = $this->customers_model->checkApiKey($post['user_id'], $post['api_key']);



        if ($user) {
            //cart items content
            $user_cart = $this->cart_model->getCart($post['user_id']);

            if(!isset($post['voucher_id'])) {
                $voucher_not_set = true;
                $voucher_code = 0;
                $voucher_discount = 0;
            } else {
                $voucher_not_set = false;
                $voucher_exists = $this->vouchers_model->getVoucher($post['voucher_id']);
                $voucher_code = $post['voucher_id'];
                $voucher = $this->vouchers_model->getVoucher($post['voucher_id']);
                $voucher_discount = $voucher[0]['discount_percentage'];
            }


            $cart_items_total = $this->cart_model->getCartTotalPrice($post['user_id']);

            $total_price = $cart_items_total[0]['total'];

            //Insert using the customer fiscal id. You can get the actual customer, with the customer.id from customers_fiscal in table 'customers'
            $customer_fiscal_id = $post['customer_fiscal_id'];

            if ($voucher_not_set || $voucher_exists) {


                if(!$voucher_not_set) {
                    $total_price = round($total_price - ($total_price * ($voucher_discount / 100)),0);
                }

                //create order
                $order_id = $this->orders_model->insert_order($total_price, $customer_fiscal_id,
                    $voucher_code, $post['shipping_address'], $voucher_discount);

                //put items inside order

                $this->orders_model->insert_order_items($order_id, $user_cart);

                $this->response('Order created with id: ' . $order_id, \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                $this->response(array('message' => 'Unknown voucher code', 'total_price' => $total_price), \Restserver\Libraries\REST_Controller::HTTP_ACCEPTED);
            }
        } else {
            $this->response('Unauthorized request', \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }


    }
}
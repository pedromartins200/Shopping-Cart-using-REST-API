<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Fiscal extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Obtem todas as categorias de produtos
     */
    public function index_get($user_id, $api_key)
    {
        $this->load->model('customers_model');
        $this->load->model('customer_fiscal_model');

        $user = $this->customers_model->checkApiKey($user_id, $api_key);

        $data = $this->customer_fiscal_model->getFiscalInfo($user_id);

        if($user)
        {
            $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response('Unauthorized request', \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }


    public function index_post()
    {
        $this->load->model('customers_model');
        $this->load->model('customer_fiscal_model');

        $post = $this->input->post(null,true);


        $user = $this->customers_model->checkApiKey($post['user_id'], $post['api_key']);

        if($user)
        {
            //verificar se nif é valido

            $check = $this->tools->validaNIF($post['nif_fiscal_info']);

            if($check) {

                $fiscal_invoice_id = $this->customer_fiscal_model->insertCustomerFiscal($post);

                $this->response('Fiscal invoice created id: '. $fiscal_invoice_id, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } else {
                //Invalid nif
                $this->response('Invalid NIF: '. $post['nif_fiscal_info'], \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            }


        } else {
            $this->response('Unauthorized request', \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}
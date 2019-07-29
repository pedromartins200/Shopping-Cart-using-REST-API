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

}
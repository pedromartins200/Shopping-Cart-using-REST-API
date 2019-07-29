<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Misc extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Obtem todas as categorias de produtos
     */
    public function index_get($info)
    {
        $this->load->model('countries_model');


        if($info == 'countries')
        {
            $data = $this->countries_model->getCountries();
            $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response('Unauthorized request', \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }




    }
}
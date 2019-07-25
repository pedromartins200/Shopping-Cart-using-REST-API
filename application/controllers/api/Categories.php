<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Categories extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Obtem todas as categorias de produtos
     */
    public function index_get()
    {
        $this->load->model('categories_model');

        $data = $this->categories_model->getCategories();

        $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}
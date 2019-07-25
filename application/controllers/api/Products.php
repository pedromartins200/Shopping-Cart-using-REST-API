<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Products extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Obtem todos os produtos que pertencem a determinada categoria
     * Se id nao for set, entao mostra todos os produtos
     * @param int $id - id da categoria do produto
     */
    public function index_get($id = 0)
    {
        $this->load->model('products_model');

        if(!empty($id) && !is_numeric($id)) {
            $this->response('id of product is not numeric', \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {

            if(!empty($id)){
                $data = $this->products_model->getProducts($id);
            }else{
                $data = $this->products_model->getAllProducts();
            }
            $this->response($data, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }

    }
}
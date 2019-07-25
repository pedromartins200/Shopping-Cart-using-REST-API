<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Authentication extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Faz registo na aplicaçao e devolve api key
     */
    public function index_post()
    {
        $this->load->model('customers_model');

        $post = $this->input->post(null, true);

        //$this->tools->_debug($post);

        if (!empty($post)) {

            $user = $this->customers_model->register_user($post);

            $this->response($user, \Restserver\Libraries\REST_Controller::HTTP_CREATED);

        } else {
            $this->response('Error', \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
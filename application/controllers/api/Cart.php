<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Cart extends \Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obter o shopping cart atual deste user
     * @param $user_id - id do user
     * @param $api_key - key api que obtem no registo
     * @param $voucher_key (optional) - get current cart and the total price with discount
     */
    public function index_get($user_id, $api_key, $voucher_key = FALSE)
    {
        $this->load->model('cart_model');
        $this->load->model('vouchers_model');


        $user_cart = $this->cart_model->getCart($user_id);
        if(!empty($user_cart)) {

            if($api_key == $user_cart[0]['api_key'])
            {
                $voucher_exists = $this->vouchers_model->getVoucher($voucher_key);

                $cart_items_total = $this->cart_model->getCartTotalPrice($user_id);

                $total_price = $cart_items_total[0]['total'];

                if($voucher_exists && !$voucher_key == FALSE)
                {
                    $voucher = $this->vouchers_model->getVoucher($voucher_key);

                    $total_price = round($total_price - ($total_price * ($voucher[0]['discount_percentage'] / 100)),0);

                    $this->response(array('voucher_exists' => '1','voucher_id' => $voucher[0]['id'],'discount_price' => $total_price,'cart'=>$user_cart),\Restserver\Libraries\REST_Controller::HTTP_OK);

                } else {
                    //acept request but voucher code was wrong
                    $this->response(array('voucher_exists' => '0','cart' => $user_cart),\Restserver\Libraries\REST_Controller::HTTP_ACCEPTED);

                }
            } else {
                $this->response('Unauthorized request',\Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            //no cart items
            $this->response(array('cart'=> array()),\Restserver\Libraries\REST_Controller::HTTP_OK);
        }

    }

    /**
     * Adiciona um produto ao carrinho
     * id do produto
     * quantidade do produto
     * user_id
     * api key
     */
    public function index_post()
    {
        $this->load->model('cart_model');
        $this->load->model('customers_model');

        //Apenas pode adicionar items ao carrinho se tiver uma api key valida

        $post = $this->input->post(null,true);

        $user = $this->customers_model->checkApiKey($post['user_id'], $post['api_key']);

        //valid key
        if($user)
        {
            //obter cart id deste user
            $cart_id = $this->cart_model->getUserCart($post['user_id'])[0]['cart_id'];

            //inserir item no carrinho
            $ok = $this->cart_model->insertItem($cart_id, $post['user_id'], $post['product_id'],$post['quantity']);

            $this->response($post['quantity'].' Items com id = '.$post['product_id']. ' foram inseridos no carrinho', \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $this->response('Unauthorized request',\Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove um item do shopping cart, ou tudo.
     * se product id nao estiver set, entao significa apagar todo o conteudo do carrinho
     */
    public function index_delete($user_id, $api_key, $product_id = 0)
    {
        $this->load->model('cart_model');
        $this->load->model('customers_model');

        $user = $this->customers_model->checkApiKey($user_id, $api_key);

        //valid key
        if($user) {
            //apagar o carrinho todo
            if(empty($product_id))
            {
                $this->cart_model->deleteCart($user_id);
                $this->response('Shopping cart items removed', \Restserver\Libraries\REST_Controller::HTTP_OK);
            } else {
                //apagar apenas este item do carrinho
                $this->cart_model->deleteCartItem($user_id, $product_id);
                $this->response('Item with id = '.$product_id.' removed from cart', \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
        } else {
            $this->response('Unauthorized request',\Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }

    }

    /**
     * Atualiza as quantidades do produto no shopping cart
     */
    public function index_patch($user_id, $api_key, $product_id, $quantity)
    {
        $this->load->model('cart_model');
        $this->load->model('customers_model');


        $user = $this->customers_model->checkApiKey($user_id, $api_key);

        //valid key
        if($user)
        {
            //obter cart id deste user
            $cart_id = $this->cart_model->getUserCart($user_id)[0]['cart_id'];

            $this->cart_model->updateCartItem($user_id, $product_id, $quantity);

            $this->response('Shopping cart updated', \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->response('Unauthorized request',\Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}
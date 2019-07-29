<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model');
        $this->load->model('cart_model');
    }

    public function register()
    {
        $session_data = $this->session->userdata('logged_in');
        if (!isset($session_data)) {

            $post = $this->input->post(null, true);
            if (empty($post)) {
                $this->render('register');
            } else {

                $this->form_validation->set_rules('name', 'Your name field', 'required');
                $this->form_validation->set_rules('email', 'Your email field', 'required|valid_email|is_unique[customers.email]');
                $this->form_validation->set_rules('password', 'Your password field', 'required|min_length[7]');
                $this->form_validation->set_rules('password-confirmation', 'Password confirmation field', 'required|matches[password]');

                if ($this->form_validation->run() == false) {
                    //registo falhou
                    $this->render('register');
                } else {
                    $client = new GuzzleHttp\Client();
                    //realizar registo na API
                    try {
                        $user = $client->request('POST', 'http://localhost/challenge/api/Authentication', [
                            'auth' => ['admin', '1234'],
                            'form_params' => [
                                'name' => $post['name'],
                                'email' => $post['email'],
                                'password' => $post['password']
                            ]
                        ]);
                    } catch (GuzzleHttp\Exception\ClientException $e) {
                        $this->tools->_debug($e);
                    }

                    //$this->tools->_debug($user->getBody()->getContents());
                    $this->data['info'] = "Account created sucessfully. You can login now";
                    $this->render('register');
                }

            }

        } else {
            //Um utilizador logado nao faz sentido poder fazer registo
            redirect('/home');
        }
    }


    public function login()
    {
        $post = $this->input->post(null, true);


        if (empty($post)) {
            $session_data = $this->session->userdata('logged_in');
            if (!isset($session_data)) {
                $this->render('login');
            } else {
                redirect('/home');
            }
        } else {

            //se o post nao esta empty, significa que houve tentativa de login
            //vamos tentar validar o login
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == false) {
                //houve validation errors
                $this->render('login');
            } else {

                $tupple = $this->customers_model->validate_user($post);

                if ($tupple) {
                    $name = $tupple[0]['name'];
                    $mail = $tupple[0]['email'];
                    $id = $tupple [0]['id'];
                    $api_key = $tupple[0]['api_key'];

                    //passar tudo o que esta no cart em session para a uma tabela com este user ID
                    $this->createCart($tupple);

                    $sess_array = array('id' => $id, 'name' => $name, 'email' => $mail, 'api_key' => $api_key);
                    $this->session->set_userdata('logged_in', $sess_array);


                    redirect('/home');
                } else {
                    //$this->response($post, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
                    $this->render('login');
                }

            }

            //independentemente de o login ter sido bem feito ou nao na api, vamos sempre para home
            //Se estiver logado vai existir a variavel session data (logged_in)

        }
    }

    private function createCart($user)
    {
        //Verificar se este utilizador ja tem um cart na base de dados

        //Se sim, nao vale a pena criar outro

        //Se nao, criar um cart com os items da session

        $user_cart = $this->cart_model->checkUserCart($user[0]['id']);

        if(!$user_cart) {

            $cart = array(
                'user_id' => $user[0]['id']
            );

            $this->db->insert('cart', $cart);

            if(isset($_SESSION['cart'])) {

                $id_cart_inserted = $this->db->insert_id();


                foreach ($_SESSION['cart'] as $item) {
                    $cart_items = array(
                        'cart_id' => $id_cart_inserted,
                        'user_id' => $user[0]['id'],
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price_per_product' => $item['price']
                    );
                    $this->db->insert('cart_items', $cart_items);
                }
            }

        }
    }

    public function logout()
    {
        if ($this->session->userdata('logged_in')) {
            $this->session->unset_userdata('logged_in');
            session_destroy();
        }
        redirect('/home');

    }


}

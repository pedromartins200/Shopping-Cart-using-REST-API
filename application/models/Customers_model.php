<?php

class Customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register_user($post)
    {
        $date = date("Y-m-d H:i:s");
        $nome = $post['name'];
        $email = $post['email'];
        $pwd1 = $post['password'];
        $password = substr(md5($pwd1),0,32);
        $key = $this->tools->generateRandomString();
        $sql = "INSERT INTO customers (name, email, created_at, updated_at, password_digest,api_key) 
		VALUES (?,?,?,?,?,?);";
        $this->db->query($sql, array($nome,$email,$date,$date,$password,$key));
        $user_id = $this->db->insert_id();

        //obter a API KEY
        $get_user = "SELECT * FROM customers WHERE customers.id = ?;";
        $q = $this->db->query($get_user,array($user_id));

        $user_array = $q->result_array();

        return array('id' => $user_array[0]['id'], 'api_key' => $user_array[0]['api_key']);
    }

    public function validate_user($post)
    {
        $email = $post['email'];
        $pwd1 = $post['password'];
        $password = substr(md5($pwd1),0,32);
        $sql = "SELECT * FROM customers WHERE email = ? AND password_digest = ?;";
        $query = $this->db->query($sql, array($email, $password));
        return $query->result_array();
    }

    public function checkApiKey($user_id, $api_key)
    {
        $sql = "SELECT * FROM customers WHERE id = ? AND api_key = ?;";
        $query = $this->db->query($sql,array($user_id, $api_key));
        if($query->num_rows() >0) {
            return true;
        }
        return false;
    }
}
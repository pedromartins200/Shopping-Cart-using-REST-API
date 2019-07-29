<?php

class Customer_fiscal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getFiscalInfo($customer_id)
    {
        $sql = "SELECT * FROM customer_fiscal WHERE customer_id = ?;";
        $query = $this->db->query($sql, array($customer_id));
        return $query->result_array();
    }



    public function insertCustomerFiscal($data)
    {
        $created = date('Y-m-d H:i:s');

        $customer_fiscal = array(
            'nif' => $data['nif_fiscal_info'],
            'address' => $data['address_fiscal_info'],
            'customer_name' => $data['name_fiscal_info'],
            'city' => $data['city_fiscal_info'],
            'country' => $data['country_fiscal_info'],
            'zip_code' => $data['zipcode_fiscal_info'],
            'customer_id' => $data['customer_id'],
            'created_at' => $created
        );

        $this->db->insert('customer_fiscal',$customer_fiscal);

        return $this->db->insert_id();
    }
}
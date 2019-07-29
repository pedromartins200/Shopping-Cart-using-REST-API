<?php

class Customer_fiscal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getFiscalInfo($customer_id)
    {
        $sql = "SELECT * FROM customer_fiscal WHERE id = ?;";
        $query = $this->db->query($sql, array($customer_id));
        return $query->result_array();
    }

    /**
     * Guarda ou actualiza um registo
     *
     * @param $data
     * @return bool
     */
    public function save($data) {

        // Verifica se está a criar ou a actualizar
        if(empty($data['id'])) {
            // Preenche os defaults
            $defaults = [];
            $data = array_merge($defaults, $data);

            //unset($data['id']);
            // novo registo
            return ($this->db->insert($this->tableName, $data))? $id = $this->db->insert_id(): false;
        } else {
            // actualiza registo
            $id = $data['id'];
            unset($data['id']);
            return ($this->db->update($this->tableName, $data, ['id' => $id]))? $id:false;
        }

        return false;
    }
}
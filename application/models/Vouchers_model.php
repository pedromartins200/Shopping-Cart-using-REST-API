<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getVoucher($voucher_key)
    {
        $query = "SELECT * FROM vouchers WHERE voucher_key = ?;";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }


}
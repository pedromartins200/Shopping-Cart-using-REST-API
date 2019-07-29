<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function voucherCheck($voucher_key)
    {
        $query = "SELECT * FROM vouchers WHERE voucher_key = ? OR id = ?;";
        $q = $this->db->query($query,array($voucher_key, $voucher_key));
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getVoucher($voucher_key)
    {
        $query = "SELECT * FROM vouchers WHERE voucher_key = ? OR id = ?;";
        $q = $this->db->query($query,array($voucher_key, $voucher_key));
        return $q->result_array();
    }


}
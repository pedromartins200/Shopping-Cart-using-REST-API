<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('templates/parts/header.php');

echo $the_view_content;

$this->load->view('templates/parts/footer.php');

?>

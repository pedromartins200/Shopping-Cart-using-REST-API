<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class errors extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function error404()
    {
        $this->render('404');
    }
}

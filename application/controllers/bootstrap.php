<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bootstrap extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }


    public function index()
    {
        $this->load->view('bootstrap/index');
    }

    public function forms() {
        $this->load->view('bootstrap/forms');
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Button extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->helper('url');         // get base_url
        $this->load->model('person_model'); // load person model
    }

    public function index()
    {
        $this->load->view('button/index');
    }

}

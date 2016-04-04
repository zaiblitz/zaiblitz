<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->helper('url');         // get base_url
        $this->load->model('person_model'); // load person model
    }

    public function index()
    {
        $this->load->view('autocomplete/index');
    }

    public function person_name() {
        echo $this->person_model->get_person_name();

        //$data = array('Merwin', 'Dale', 'Domingo');
        //echo json_encode($data);
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->helper('url');         // get base_url
        $this->load->model('person_model'); // load person model
        $this->load->library('PHPExcel');
    }

    public function index() {
        $this->load->view('datatables/index');
    }

    public function person_list() {
       echo $this->person_model->person_list();
    }

    public function process() {
        $this->person_model->save_person($this->input->post('pr_id'), $this->input->post());
    }

    public function process_list() {
        $this->person_model->save_person_lists($this->input->post('list'));
    }

    public function delete_person() {
        $this->person_model->delete_person($this->input->post('personIds'));
    }

    public function check_username() {
        $this->person_model->check_username($this->input->post('username'));
    }

    public function export() {

      @header('Content-Type: application/csv; charset=utf-8');
      @header('Content-Disposition: attachment; filename="'.$fi.'.csv"');
      readfile($filename);

    }
}

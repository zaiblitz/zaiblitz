<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


	public function __construct() {
		parent::__construct();

		$this->load->model('admin_model');

		$this->load->helper('url');
	}

	public function index() {
		$this->load->view('welcome_message');
	}

	public function details() {

		$this->load->view('admin/details');
	}

	public function admin_list() {

		echo $this->admin_model->admin_list();
	}
}


/* End of file home.php */
/* Location: ./application/controllers/home.php */
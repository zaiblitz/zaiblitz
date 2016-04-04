<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample extends CI_Controller {

	/*
	 * Constructor is a method which is automatically called on class initiation
	 */

	public function __construct() {
		parent::__construct();

		$this->load->helper('url'); 	// load base_url();
	}
	public function index() {
		$this->load->view('welcome_message');
	}

	public function data() {
		echo base_url();

		echo 'ok';
	}
}


/* End of file home.php */
/* Location: ./application/controllers/home.php */
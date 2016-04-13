<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/*
	 * Constructor is a method which is automatically called on class initiation
	 */

	public function __construct() {
		parent::__construct();

		$this->load->helper('url'); 	// load base_url();
	}
	public function index() {
		$user_data = array(
			array(
				'id' => 1,
				'name' => 'Merwin Dale',
				'age' => 26,
				'address' => 'Boni'
			),
			array(
				'id' => 1,
				'name' => 'Jaypee Ramos',
				'age' => 25,
				'address' => 'Lomboy'
			)
		);

		$result = array();
		foreach( $user_data as $key => $x ) {
			unset($x['id']);	// remove id in display
			$result[] = $x;
		}
		print_r($result);
	}

	public function data() {

	}
}


/* End of file home.php */
/* Location: ./application/controllers/home.php */
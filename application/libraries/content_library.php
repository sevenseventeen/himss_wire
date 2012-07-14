<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_Library {

	protected $ci;
	
	public function __construct() {
		$this->ci =& get_instance();
	}
	
	public function load_footer() {
		//$this->ci->load->model('content_model');
		//$data['partner_links'] = $this->ci->content_model->get_partner_links();
		$this->ci->load->view('_includes/footer');
	}

}
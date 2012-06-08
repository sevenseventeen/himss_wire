<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_Controller extends CI_Controller {
	
	public function index() {}
	
	public function set_accordion($accordion_level) {
		$data = array('admin_accordion_state' => $accordion_level);
		$this->session->set_userdata($data);
	}
	
	public function set_tab($tab_state) {
		$data = array('admin_tab_state' => $tab_state);
		$this->session->set_userdata($data);
	}
}										




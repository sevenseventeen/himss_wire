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
	
	public function order_partner_links() {
		$this->load->model('content_model');
		foreach($_POST['partner_links'] as $key=>$value) {
			$partner_link_data = array(
				'partner_link_position'	=> $key
			);
			$partner_link_updated = $this->content_model->update_partner_link_order($value, $partner_link_data);
		}
	}
	
	public function order_faqs() {
		$this->load->model('content_model');
		foreach($_POST['sortable_faqs'] as $key=>$value) {
			$faq_data = array(
				'faq_position' => $key
			);
			$partner_link_updated = $this->content_model->update_faq_order($value, $faq_data);
		}
	}
}										




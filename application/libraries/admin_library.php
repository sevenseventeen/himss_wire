<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Library {

	protected $ci;
	
	public function __construct() {
		$this->ci =& get_instance();
	}
	
	public function load_admin_view($additional_data = NULL) {
		$this->ci->load->model('content_model');
		$this->ci->load->model('account_model');
		$this->ci->load->model('user_model');
		$data['categories'] = $this->ci->content_model->get_categories();
		$data['subscribers'] = $this->ci->account_model->get_subscribers();
		$data['subscribers_with_remaining_articles'] = $this->ci->account_model->get_subscribers_with_remaining_articles();
		$data['network_partners'] = $this->ci->account_model->get_network_partners();
		$data['articles'] = $this->ci->content_model->get_all_articles();
		$data['static_pages'] = $this->ci->content_model->get_static_pages();
		$data['external_account_types'] = $this->ci->account_model->get_external_account_types();
		$data['internal_account_types'] = $this->ci->account_model->get_internal_account_types();
		$data['administrators'] = $this->ci->account_model->get_administrator_accounts();
		$data['editors'] = $this->ci->account_model->get_editor_accounts();
		$data['user_type'] = $this->ci->auth->user_type();
		$data['feature_module'] = $this->ci->content_model->get_feature_module();
		$data['banner_ads'] = $this->ci->content_model->get_banner_ads();
		$data['websites'] = $additional_data;
		if($data['user_type'] == "Administrator" || $data['user_type'] == "Editor") {
			$this->ci->load->view('admin_view', $data);	
		} else {
			redirect('admin/login');
		}
		
	}

}
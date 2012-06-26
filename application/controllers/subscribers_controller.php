<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscribers_Controller extends CI_Controller {
	
	public function index() {
		echo "Subscriber_Controller";
	}
	
	public function request_story() {
		$user_id = $this->input->post('user_id');
		if ($user_id != $this->auth->get_logged_in_user_id()) {
			redirect('authentication/login');
		}
		
		$config['upload_path'] = './_uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  =  TRUE;
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload("supporting_document")) {
			// TODO Set custom error system here.
			//$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
			echo "uploaded";
		} else {
			echo "Did not uplaod";
		}
		
		
		// $this->load->model('account_model');
		// $this->load->model('user_model');
		// $this->load->model('subscription_model');
		// $this->load->model('content_model');
		// $data['user_account'] = $this->user_model->get_user_by_id($user_id);
		// $data['subscriber_account'] = $this->account_model->get_subscriber_by_user_id($user_id);
		// $data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
		// $data['articles'] = $this->content_model->get_all_articles_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
		// $data['reports'] = $this->content_model->get_reports_by_subscriber_account_id($data['subscriber_account'][0]->subscriber_account_id);
		// $this->load->view('subscriber_account_view', $data);
	}
	
		function update_banner_ad() {
		$banner_ad_id = $this->input->post('banner_ad_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('banner_url', 'Banner URL', 'required');
		$config['upload_path'] = './_uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  =  TRUE;
		$this->load->library('upload', $config);
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			if (!$this->upload->do_upload("banner_image")) {
				// TODO Set custom error system here.
				//$error = array('error' => $this->upload->display_errors());
				//$this->load->view('upload_form', $error);
			} else {
				$image_data = $this->upload->data();
				$banner_data = array(
					'banner_image_path'	=> $image_data['file_name'],
					'banner_url'		=> $this->input->post('banner_url')
				);
				$banner_updated = $this->content_model->update_banner_ad($banner_ad_id, $banner_data);
				if($banner_updated) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
			}
		}
	}
	
	
}




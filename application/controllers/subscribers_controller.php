<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscribers_Controller extends CI_Controller {
	
	public function request_story() {
		$user_id = $this->input->post('user_id');
		if ($user_id != $this->auth->get_logged_in_user_id()) {
			redirect('authentication/login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('website', 'Website', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
		$this->form_validation->set_rules('request_specifics', 'Request Specifics', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->model('account_model');
			$this->load->model('user_model');
			$this->load->model('subscription_model');
			$this->load->model('content_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['subscriber_account'] = $this->account_model->get_subscriber_by_user_id($user_id);
			$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
			$data['articles'] = $this->content_model->get_all_articles_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
			$data['reports'] = $this->content_model->get_reports_by_subscriber_account_id($data['subscriber_account'][0]->subscriber_account_id);
			$this->load->view('subscriber_account_view', $data);
		} else { 
			$now_offset = 0;
			$file_names = array();
			$config['upload_path'] 		= './_uploads/';
			$config['allowed_types']	= 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx';
			$config['max_size']			= '2048';
			$config['overwrite']		=  FALSE;
			$this->load->library('upload', $config);
			foreach($_FILES as $key => $value) {
				$now_offset++;
				$config['file_name'] = now()+$now_offset;
				$this->upload->initialize($config);
	            if(!empty($value['tmp_name'])) {
	                if(!$this->upload->do_upload($key)) {                                           
	                    echo $this->upload->display_errors();
	                } else {
	                	$file_data = $this->upload->data();
						array_push($file_names, $file_data['file_name']);
	                }
	            }
	        }
			$file_path = base_url()."_uploads/".$file_data['file_name'];
			$to = $this->config->item('email_to_admin');
			$from_email = $this->input->post('email');
			$from_name = "HIMSS Wire Support Request"; //$this->input->post('company_name');
			$message = "First Name: "			.$this->input->post('first_name')." \n ";
			$message .= "Last Name: "			.$this->input->post('last_name')." \n ";
			$message .= "Company Name: "		.$this->input->post('company_name')." \n ";
			$message .= "Website: "				.$this->input->post('website')." \n ";
			$message .= "Phone Number: "		.$this->input->post('phone_number')." \n ";
			$message .= "Request Specifics: "	.$this->input->post('request_specifics')." \n ";
			foreach($file_names as $file_name) {
				$file_path = base_url()."_uploads/".$file_name;
				$message .= "Supporting Files: "	.$file_path." \n ";
			}
			$this->load->library('email');
	        $this->email->from($from_email, $from_name);
	        $this->email->to($to);
	        $this->email->subject('Story Request');
	        $this->email->message($message);
			if ($this->email->send()) {
	            $this->load->model('account_model');
				$this->load->model('user_model');
				$this->load->model('subscription_model');
				$this->load->model('content_model');
				$data['user_account'] = $this->user_model->get_user_by_id($user_id);
				$data['subscriber_account'] = $this->account_model->get_subscriber_by_user_id($user_id);
				$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
				$data['articles'] = $this->content_model->get_all_articles_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
				$data['reports'] = $this->content_model->get_reports_by_subscriber_account_id($data['subscriber_account'][0]->subscriber_account_id);
				$this->session->set_flashdata('message', 'Your request has been sent. Thanks!');
				$this->load->view('subscriber_account_view', $data);
	        } else {
				echo $this->email->print_debugger();
	        }			
		}
	}
}




<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends CI_Controller {
	
	public function index() {
		echo "Partner Controller";
	}
	
	
	 // $to = $this->config->item('email_to_admin');
			// $this->load->library('email');
	        // $this->email->from($email, $name);
	        // $this->email->to($to);
	        // $this->email->subject('Contact from eTradeInBids Contact Page');
	        // $this->email->message($message);
			// if ($this->email->send()) {
	            // $data['status_message'] = "<h1>Sucess</h1><p>Thanks for contacting eTradeInBids.</p>";
	            // $this->load->view('contact_us_view', $data);
	        // } else {
	            // $data['status_message'] = "<h1>Sorry</h1><p>There was an error sending your email. Please try again later.</p>";
	            // $this->load->view('contact_us_view', $data);
	        // }
	
	
	public function request_support() {
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
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
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('content_model');
			$this->load->model('account_model');
			$this->load->model('user_model');
			$user_id = $this->session->userdata('user_id');
			$data['network_partner'] = $this->account_model->get_network_partner_by_user_id($user_id);
			$data['faqs'] = $this->content_model->get_faqs();
			$data['user'] = $this->user_model->get_user_by_id($user_id);
			$this->load->view('network_partner_view', $data);
		} else {
			$to = $this->config->item('email_to_admin');
			$from_email = $this->input->post('email');
			$from_name = $this->input->post('company_name');
			$this->load->library('email');
	        $this->email->from($from_email, $from_name);
	        $this->email->to($to);
	        $this->email->subject('Support Request');
	        $this->email->message("test message");
			if ($this->email->send()) {
	            echo "Mail Sent";
	        } else {
	            echo "Mail Not Sent";
				echo $this->email->print_debugger();
	        }			
		}
	}
 
}




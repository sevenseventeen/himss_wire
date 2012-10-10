<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Controller extends CI_Controller {
	
	/*
	 * 
	 * Login Functions
	 * 
	 * 
	 */
	 
	public function login() {
		$this->load->view('login_view');
	}
	 
	public function login_user() {
		$this->load->model('auth_model');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$logged_in = $this->auth_model->login($email, $password);
		if ($logged_in) {
			$user_id = $this->session->userdata('user_id');
			switch ($this->auth->user_type()) {
				case "Administrator":
					redirect('admin');
					break;
				case "Editor":
					redirect('admin');
					break;
				case "Network Partner":
					redirect("network_partner/$user_id");
					break;
				default:
					redirect("subscriber/$user_id");
					break;
			}
		} else {
			//$this->load->view('logged_out_view');
			$this->session->set_flashdata('message', 'Sorry, that email/password combination does not match our records.');
			redirect('authentication/login');
		}
	}
	
	public function logout() {
		$this->load->model('auth_model');
		$this->auth_model->logout();
		$this->load->view('logged_out_view');
	}
}




<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!class_exists('CI_Model')) { class CI_Model extends Model {} }

class Auth_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->library('session');
	}
	
	public function login($email, $password) {
		if (empty($email) || empty($password)) {
			return FALSE;
		}
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get();
		$result = $query->row();
		if ($query->num_rows() == 1) {
			if ($result->password === $password) {
				$session_data = array(
					'user_id' => $result->user_id
				);
				//echo "USER ID: $result->user_id";
				$this->session->set_userdata($session_data);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
		return TRUE;
	}
	
	public function logged_in() {
		return (bool) $this->session->userdata('user_id');
	}

	public function get_user_by_email($email) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$query = $this->db->get();
		return $query->result();
	}
}

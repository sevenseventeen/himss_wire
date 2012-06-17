<?php 

class User_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function add_user($data) {
		$result = $this->db->insert('users', $data);
		return $result; 
	}
	
	function update_user($user_id, $user_data) {
		$result = $this->db->update('users', $user_data, "user_id = $user_id");
        return $result;
	}
	
	function get_user_by_id($user_id) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id', $user_id);
		$this->db->join('account_types', 'users.account_type_id = account_types.account_type_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_user_by_email($email) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$query = $this->db->get();
		return $query->result();
	}
	
	function delete_user($user_id) {
		$user_deleted = $this->db->delete('users', "user_id = $user_id");
		return $user_deleted;
	}
	 
}
	
?>
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
	
	
	// function get_administrator_account_by_id($admin_id) {
		// $this->db->select('*');
		// $this->db->from('administrator_accounts');
		// $this->db->where('administrator_account_id', $admin_id);
		// $this->db->join('users', 'users.account_type_id = account_types.account_type_id', 'left');
		// $query = $this->db->get();
		// return $query->result();
	// }
// 	
	// function get_editor_account_by_id($editor_id) {
		// $this->db->select('*');
		// $this->db->from('editor_accounts');
		// $this->db->where('editor_accounts', $editor_id);
		// $this->db->join('users', 'users.account_type_id = account_types.account_type_id', 'left');
		// $query = $this->db->get();
		// return $query->result();
	// }
	
}
	
?>
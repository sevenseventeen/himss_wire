<?php 

class Account_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	/*
	 * 
	 * Add Functions 
	 * 
	 * 
	 */
	
	function add_subscriber($data) {
		$result = $this->db->insert('subscriber_accounts', $data);
		return $result; 
	}
	
	function add_network_partner($data) {
		$result = $this->db->insert('network_partner_accounts', $data);
		return $result; 
	}
	
	function add_administrator($data) {
		$result = $this->db->insert('administrator_accounts', $data);
		return $result; 
	}
	
	function add_editor($data) {
		$result = $this->db->insert('editor_accounts', $data);
		return $result; 
	}
	
	function add_websites($data) {
		$result = $this->db->insert('network_partner_websites', $data);
		return $result; 
	}
	
	/*
	 * 
	 * Get Functions 
	 * 
	 * 
	 */
	
	function get_subscribers() {
		$this->db->select('*');
		$this->db->from('subscriber_accounts');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_subscribers_with_remaining_articles() {
		$this->db->select('*');
		$this->db->from('subscriber_accounts');
		$this->db->join('subscriptions', 'subscriptions.subscriber_account_id = subscriber_accounts.subscriber_account_id', 'left');
		$this->db->where('subscriptions.stories_remaining >', 0);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_network_partners() {
		$this->db->select('*');
		$this->db->from('network_partner_accounts');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_administrator_accounts() {
		$this->db->select('*');
		$this->db->from('administrator_accounts');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_subscriber_by_id($subscriber_account_id) {
		$this->db->select('*');
		$this->db->from('subscriber_accounts');
		$this->db->where('subscriber_account_id', $subscriber_account_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_subscriber_by_user_id($user_id) {
		$this->db->select('*');
		$this->db->from('subscriber_accounts');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_network_partner_by_id($network_partner_account_id) {
		$this->db->select('*');
		$this->db->from('network_partner_accounts');
		$this->db->where('network_partner_account_id', $network_partner_account_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_network_partner_by_user_id($user_id) {
		$this->db->select('*');
		$this->db->from('network_partner_accounts');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_admin_account_by_id($admin_account_id) {
		$this->db->select('*');
		$this->db->from('administrator_accounts');
		$this->db->where('administrator_account_id', $admin_account_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_editor_account_by_id($editor_account_id) {
		$this->db->select('*');
		$this->db->from('editor_accounts');
		$this->db->where('editor_account_id', $editor_account_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_external_account_types() {
		$this->db->select('*');
		$this->db->from('account_types');
		$this->db->where('internal', FALSE);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_internal_account_types() {
		$this->db->select('*');
		$this->db->from('account_types');
		$this->db->where('internal', TRUE);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_editor_accounts() {
		$this->db->select('*');
		$this->db->from('editor_accounts');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_feeds_by_user_id($user_id) {
		$this->db->select('*');
		$this->db->from('feed_modules');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	/*
	 * 
	 * Update Functions 
	 * 
	 * 
	 */
	
	function update_subscriber_account($subscriber_account_id, $data) {
		$result = $this->db->update('subscriber_accounts', $data, "subscriber_account_id = $subscriber_account_id");
        return $result;
	}
	
	function update_network_partner_account($network_partner_account_id, $data) {
		$result = $this->db->update('network_partner_accounts', $data, "network_partner_account_id = $network_partner_account_id");
        return $result;
	}
	
	function update_admin_account($admin_account_id, $data) {
		$result = $this->db->update('administrator_accounts', $data, "administrator_account_id = $admin_account_id");
        return $result;
	}
	
	function update_editor_account($editor_account_id, $data) {
		$result = $this->db->update('editor_accounts', $data, "editor_account_id = $editor_account_id");
        return $result;
	}
	
	/*
	 * 
	 * Update Functions 
	 * 
	 * 
	 */
	 
	function delete_account($user_id) {
		$user_deleted = $this->db->delete('network_partner_accounts', "user_id = $user_id");
		$user_deleted = $this->db->delete('subscriber_accounts', "user_id = $user_id");
		return $user_deleted;
	}
	
	
	
}
	
?>
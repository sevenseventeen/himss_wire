<?php 

class Subscription_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	/*
	 * 
	 * Add Functions 
	 * 
	 * 
	 */
	
	function add_subscription($data) {
		$result = $this->db->insert('subscriptions', $data);
		return $result;
	}
	
	/*
	 * 
	 * Get Functions 
	 * 
	 * 
	 */
	
	function get_subscription_by_account_id($subscriber_account_id) {
		$this->db->select('*');
		$this->db->from('subscriptions');
		$this->db->where('subscriber_account_id', $subscriber_account_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	/*
	 * 
	 * Update Functions 
	 * 
	 * 
	 */
	
	function update_subscription($subscription_id, $data) {
		$result = $this->db->update('subscriptions', $data, "subscription_id = $subscription_id");
        return $result;
	}
	
}
	
?>
<?php 

class Feed_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function get_articles() {
		$this->db->select('*');
		$this->db->from('articles');
		$query = $this->db->get();
		return $query->result();
	}
	
}
	
?>
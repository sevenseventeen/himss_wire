<?php 

class Content_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	/*
	 * 
	 * Add Functions
	 * 
	 * 
	 */
	
	function add_article($data) {
		$result = $this->db->insert('articles', $data);
		return $result;
	}
	
	function add_category($data) {
		$result = $this->db->insert('article_categories', $data);
		return $result;
	}
	
	function add_footer_link($data) {
		$result = $this->db->insert('footer_links', $data);
		return $result;
	}
	
	function add_faq($data) {
		$result = $this->db->insert('faqs', $data);
		return $result;
	}
	
	function add_report($data) {
		$result = $this->db->insert('reports', $data);
		return $result;
	}
	
	/*
	 * 
	 * Get Functions
	 * 
	 * 
	 */
	
	function get_articles($limit='1000000') {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	function get_pending_articles($limit='1000000') {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_status', 'Pending');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_published_articles($limit='1000000') {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_status', 'published');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_categories() {
		$this->db->select('*');
		$this->db->from('article_categories');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_category_by_id($category_id) {
		$this->db->select('*');
		$this->db->from('article_categories');
		$this->db->where('article_category_id', $category_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_article_by_id($article_id) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_id', $article_id);
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_articles_by_category_id($category_id, $limit=10000000) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('articles.article_category_id', $category_id);
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_static_pages() {
		$this->db->select('*');
		$this->db->from('static_pages');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_static_page_by_id($page_id) {
		$this->db->select('*');
		$this->db->from('static_pages');
		$this->db->where('page_id', $page_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_static_page_content_by_id($page_id) {
		$this->db->select('*');
		$this->db->from('static_page_content');
		$this->db->where('static_page_id', $page_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_feature_module() {
		$this->db->select('*');
		$this->db->from('feature_module');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_banner_ads() {
		$this->db->select('*');
		$this->db->from('banner_ads');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_footer_links() {
		$this->db->select('*');
		$this->db->from('footer_links');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_faqs() {
		$this->db->select('*');
		$this->db->from('faqs');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_related_articles($search_term) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where("MATCH (article_body) AGAINST ('$search_term')", NULL, FALSE);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_reports_by_subscriber_account_id($subscriber_account_id) {
		$this->db->select('*');
		$this->db->from('reports');
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
	
	function update_article($article_id, $article_data) {
		$result = $this->db->update('articles', $article_data, "article_id = $article_id");
        return $result;
	}
	
	function update_category($category_id, $category_data) {
		$result = $this->db->update('article_categories', $category_data, "article_category_id = $category_id");
        return $result;
	}
	
	function update_feature_module($module_entry_id, $data) {
		$result = $this->db->update('feature_module', $data, "module_entry_id = $module_entry_id");
    	return $result;
	}
	
	function update_banner_ad($banner_ad_id, $data) {
		$result = $this->db->update('banner_ads', $data, "banner_ad_id = $banner_ad_id");
    	return $result;
	}
	
	// TODO This seems a little convoluted, double check this when awake.
	// TODO The content should probably be based on page_content_id rather than page_id
	
	function update_static_page($page_id, $content_data, $name_data) {
		$page_name_updated = $this->db->update('static_pages', $name_data, "page_id = $page_id");
		if ($page_name_updated) {
			$page_content_updated = $this->db->update('static_page_content', $content_data, "static_page_id = $page_id");
			 return $page_content_updated;	
		 } else {
			return FALSE;
		 }
	}
	
	
	/*
	 * 
	 * Delete Functions
	 * 
	 * 
	 */

}
	
?>
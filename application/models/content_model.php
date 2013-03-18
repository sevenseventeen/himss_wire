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
	
	function add_partner_link($data) {
		$result = $this->db->insert('partner_links', $data);
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
	
	function add_feed_module($data) {
		$result = $this->db->insert('feed_modules', $data);
		return $result;
	}
	
	/*
	 * 
	 * Get Functions
	 * 
	 * 
	 */
	
	function get_all_articles($limit='1000000') {
		$this->db->select('*');
		$this->db->from('articles');
		
		$this->db->join('subscriber_accounts', 'subscriber_accounts.subscriber_account_id = articles.subscriber_id', 'left');
		
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_articles_by_account_id($subscriber_id) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_status !=', 'Draft');
		$this->db->where('subscriber_id', $subscriber_id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_published_articles_by_account_id($subscriber_id) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_status', 'Published');
		$this->db->where('subscriber_id', $subscriber_id);
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
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		$this->db->order_by("publish_date", "desc");
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_categories() {
		$this->db->select('*');
		$this->db->from('article_categories');
		$this->db->order_by("category_name", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_active_category_ids() {
		$this->db->select('article_category_id');
		$this->db->group_by("article_category_id");
		//$this->db->order_by("category_name", "asc"); 
		$this->db->from('articles');
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
	
	function get_category_by_slug($category_slug) {
		$this->db->select('*');
		$this->db->from('article_categories');
		$this->db->where('category_slug', $category_slug);
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
	
	function get_article_by_slug($article_slug) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_slug', $article_slug);
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_articles_by_category_id($category_id, $limit=10000000) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('articles.article_category_id', $category_id);
		$this->db->where('article_status', 'published');
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		$this->db->order_by("publish_date", "desc");
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}
	
	// function get_articles_by_category_slug($category_slug, $limit=10000000) {
		// $this->db->select('*');
		// $this->db->from('articles');
		// $this->db->where('articles.category_slug', $category_slug);
		// $this->db->where('article_status', 'published');
		// $this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
		// $this->db->order_by("publish_date", "desc");
		// $this->db->limit($limit);
		// $query = $this->db->get();
		// return $query->result();
	// }
	
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
	
	function get_feature_module_optional() {
		$this->db->select('*');
		$this->db->from('feature_module_optional');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_banner_ads() {
		$this->db->select('*');
		$this->db->from('banner_ads');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_partner_links() {
		$this->db->select('*');
		$this->db->from('partner_links');
		$this->db->order_by("partner_link_position", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_partner_link_by_id($partner_link_id) {
		$this->db->select('*');
		$this->db->from('partner_links');
		$this->db->where('partner_link_id', $partner_link_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_faqs() {
		$this->db->select('*');
		$this->db->from('faqs');
		$this->db->order_by("faq_position", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_faq_by_id($faq_id) {
		$this->db->select('*');
		$this->db->from('faqs');
		$this->db->where('faq_id', $faq_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_search_results($search_term, $limit=1000000, $offset=0) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where("MATCH (article_body,article_title) AGAINST ('*$search_term*')", NULL, FALSE);
//		$this->db->where("MATCH (article_body,article_title) AGAINST ('*$search_term*' IN BOOLEAN MODE)", NULL, FALSE);
		$this->db->limit($limit, $offset);
		$this->db->join('article_categories', 'article_categories.article_category_id = articles.article_category_id', 'left');
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

	function get_related_articles($article_category_id, $article_slug) {
		$this->db->select('*');
		$this->db->from('articles');
		$this->db->where('article_category_id', $article_category_id);
		$this->db->where('article_slug !=', $article_slug);
		$this->db->where('article_status', 'published');
		$this->db->order_by("publish_date", "desc");
		$this->db->limit(5);
		$query = $this->db->get();
		return $query->result();
	}

	function get_feed_module_by_id($feed_module_id) {
		$this->db->select('*');
		$this->db->from('feed_modules');
		$this->db->where('feed_module_id', $feed_module_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	/*
	 * 
	 * Update Functions
	 * 
	 * 
	 */
	
	function update_partner_link_order($partner_link_id, $partner_link_data) {
		$result = $this->db->update('partner_links', $partner_link_data, "partner_link_id = $partner_link_id");
        return $result;
	}
	
	function update_article($article_id, $article_data) {
		$result = $this->db->update('articles', $article_data, "article_id = $article_id");
        return $result;
	}
	
	function update_category($category_id, $category_data) {
		$result = $this->db->update('article_categories', $category_data, "article_category_id = $category_id");
        return $result;
	}
	
	function update_feature_module($feature_module_id, $data) {
		$result = $this->db->update('feature_module', $data, "feature_module_id = $feature_module_id");
    	return $result;
	}
	
	function update_feature_module_optional($feature_module_optional_id, $data) {
		$result = $this->db->update('feature_module_optional', $data, "feature_module_optional_id = $feature_module_optional_id");
    	return $result;
	}
	
	function update_banner_ad($banner_ad_id, $data) {
		$result = $this->db->update('banner_ads', $data, "banner_ad_id = $banner_ad_id");
    	return $result;
	}
	
	function update_partner_link($partner_link_id, $data) {
		$result = $this->db->update('partner_links', $data, "partner_link_id = $partner_link_id");
    	return $result;
	}
	
	function update_faq($faq_id, $data) {
		$result = $this->db->update('faqs', $data, "faq_id = $faq_id");
    	return $result;
	}
	
	function update_faq_order($faq_id, $data) {
		$result = $this->db->update('faqs', $data, "faq_id = $faq_id");
    	return $result;
	}
	
	function update_feed_module($feed_module_id, $data) {
		$result = $this->db->update('feed_modules', $data, "feed_module_id = $feed_module_id");
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
	 
	function delete_article($article_id) {
		$article_deleted = $this->db->delete('articles', "article_id = $article_id");
		return $article_deleted;
	}
	 
	function delete_partner_link($partner_link_id) {
		$partner_link_deleted = $this->db->delete('partner_links', "partner_link_id = $partner_link_id");
		return $partner_link_deleted;
	}
	 
	function delete_faq($faq_id) {
		$faq_deleted = $this->db->delete('faqs', "faq_id = $faq_id");
		return $faq_deleted;
	}
	 
	function delete_feed_module($feed_module_id) {
		$feed_module_deleted = $this->db->delete('feed_modules', "feed_module_id = $feed_module_id");
		return $feed_module_deleted;
	}
	
}
	
?>
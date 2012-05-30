<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function index() {
		$this->load->model('auth_model');
		if ($this->auth_model->logged_in()) {
			echo "logged in";
		} else {
			echo "not logged in";
		}
		$this->load->model('content_model');
		$data['articles'] = $this->content_model->get_articles('5');
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
		$this->load->view('home_view', $data);
	}
	
	public function articles() {
		$this->load->model('content_model');
		$results = array();
		$categories = $this->content_model->get_categories();
		foreach ($categories as $category) {
			$article_category_groups = array();
			$category_id = $category->article_category_id;
			$articles = $this->content_model->get_articles_by_category_id($category_id, 2);
			foreach ($articles as $article) {
				array_push($article_category_groups, $article);
			}
			array_push($results, $article_category_groups);
		}
		$data['results'] = $results;
		$this->load->view('articles_view', $data);
	}
	
	public function article($article_id) {
		$this->load->model('content_model');
		$data['article'] = $this->content_model->get_article_by_id($article_id);
		$this->load->view('article_view', $data);
	}
	
	public function about_himss_wire($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('about_himss_wire_view', $data);
	}
	
	public function category($category_id) {
		$this->load->model('content_model');
		$data['articles'] = $this->content_model->get_articles_by_category_id($category_id);
		$this->load->view('category_view', $data);
	}
	
	public function our_network($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('about_himss_wire_view', $data);
	}

	public function privacy_policy() {
		$this->load->view('privacy_policy_view');
	}
	
	public function join_himss($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('join_himss_view', $data);
	}
	
	public function contact_us($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('contact_us_view', $data);
	}
	
	public function rss() {
		$this->load->helper('xml');
		$this->load->helper('text');
		$this->load->model('feed_model', 'feeds');
		$data['feed_name'] = 'MyWebsite.com';  
		$data['encoding'] = 'utf-8';  
		$data['feed_url'] = 'http://www.MyWebsite.com/feed';  
		$data['page_description'] = 'What my site is about comes here';  
		$data['page_language'] = 'en-en';  
		$data['creator_email'] = 'mail@me.com';  
		$data['articles'] = $this->feeds->get_articles();  
		header("Content-Type: application/rss+xml");   
       	$this->load->view('feed_view', $data);
	}
	
	
	public function my_account() {
		echo "My Account Function";
		//$user_type = $this->auth->user_type();
		// switch ($user_type) {
			// case 'administrator':
				// $this->admin_library->load_admin_view();
				// break;
			// case 'editor':
				// $this->admin_library->load_editor_view();
				// break;
			// default:
				// break;
		// }
	}
	
	public function network_partner($user_id) {
		$this->load->model('content_model');
		$this->load->model('account_model');
		$this->load->model('user_model');
		$data['network_partner'] = $this->account_model->get_network_partner_by_user_id($user_id);
		$data['faqs'] = $this->content_model->get_faqs();
		$data['user'] = $this->user_model->get_user_by_id($user_id);
		$this->load->view('network_partner_view', $data);
	}
 
}




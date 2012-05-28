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
	
	public function about_himss_wire() {
		$this->load->view('about_himss_wire_view');
	}
	
	public function our_network() {
		$this->load->view('our_network_view');
	}

	public function privacy_policy() {
		$this->load->view('privacy_policy_view');
	}
	
	public function join_himss() {
		$this->load->view('join_himss_view');
	}
	
	public function contact_us() {
		$this->load->view('contact_us_view');
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
		$user_type = $this->auth->user_type();
		switch ($user_type) {
			case 'administrator':
				$this->admin_library->load_admin_view();
				break;
			case 'editor':
				$this->admin_library->load_editor_view();
				break;
			default:
				break;
		}
		
	}
 
}


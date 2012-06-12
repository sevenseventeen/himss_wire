<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Controller extends CI_Controller {

	public function index() {
		$this->load->model('auth_model');
		if ($this->auth_model->logged_in()) {
			//echo "logged in";
		} else {
			//echo "not logged in";
		}
		$this->load->model('content_model');
		$data['articles'] = $this->content_model->get_published_articles('5');
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
		$this->load->view('home_view', $data);
	}
	
	public function linked_in() {
		$this->load->view('linked_in_view');
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
		$article = $this->content_model->get_article_by_id($article_id);
		$article_category_id = $article[0]->article_category_id; 
		$data['article'] = $article;
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
		$data['related_articles'] = $this->content_model->get_related_articles($article_category_id, $article_id);
		$this->load->view('article_view', $data);
	}
	
	public function article_search() {
		if ($this->input->post('search_term') == '') {
			$search_term = $this->session->userdata('search_term');
		} else {
			$search_term = $this->input->post('search_term');
			$this->session->set_userdata('search_term', $search_term);
		}
		$this->load->model('content_model');
		$this->load->library('pagination');
		$config['base_url'] = base_url().'article_search';
		$config['per_page'] = 5;
		$config['uri_segment'] = 2; 
		$config['total_rows'] = count($this->content_model->get_search_results($search_term));
		$this->pagination->initialize($config);
		$limit = $config['per_page'];
		$offset = $this->uri->segment($config['uri_segment']);
		$data['pagination_links'] = $this->pagination->create_links();
		$data['search_results'] = $this->content_model->get_search_results($search_term, $limit, $offset);
		$this->load->view('article_search_results_view', $data);
	}
	
	public function about_himss_wire($page_id) {
		$this->load->model('content_model');
		$data['articles'] = $this->content_model->get_published_articles('5');
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
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
		$data['articles'] = $this->content_model->get_published_articles('5');
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('our_network_view', $data);
	}

	public function privacy_policy($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('privacy_policy_view', $data);
	}
	
	public function join_himss($page_id) {
		$this->load->model('content_model');
		$data['articles'] = $this->content_model->get_published_articles('5');
		$data['feature_module'] = $this->content_model->get_feature_module();
		$data['banner_ad'] = $this->content_model->get_banner_ads();
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
		$this->load->model('content_model');
		$data['feed_name'] = 'MyWebsite.com';  
		$data['encoding'] = 'utf-8';  
		$data['feed_url'] = 'http://www.MyWebsite.com/feed';  
		$data['page_description'] = 'What my site is about goes here';  
		$data['page_language'] = 'en-en';  
		$data['creator_email'] = 'mail@me.com';  
		$data['articles'] = $this->content_model->get_published_articles();
		header("Content-Type: application/rss+xml");
       	$this->load->view('feed_view', $data);
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
	
	public function subscriber($user_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->model('subscription_model');
		$this->load->model('content_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['subscriber_account'] = $this->account_model->get_subscriber_by_user_id($user_id);
		$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
		//$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($data['subscriber_account'][0]->subscriber_account_id);
		$data['reports'] = $this->content_model->get_reports_by_subscriber_account_id($data['subscriber_account'][0]->subscriber_account_id);
		$this->load->view('subscriber_account_view', $data);
	}
	
	public function edit_subscriber_account() {
		if ($this->auth->logged_in()) {
			$user_id = $this->session->userdata('user_id'); 
			$this->load->model('account_model');
			$this->load->model('user_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['subscriber_account'] = $this->account_model->get_subscriber_by_user_id($user_id);
			$this->load->view('edit_subscriber_account_view', $data);
		} else {
			redirect('admin/login');
		}
	}
	
	public function update_subscriber_account() {
		$subscriber_account_id = $this->input->post('subscriber_account_id');
		$user_id = $this->input->post('user_id');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('website', 'Website', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
		$this->form_validation->set_rules('street_address', 'Street Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('account_model');
			$this->load->model('user_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['subscriber_account'] = $this->account_model->get_subscriber_by_id($subscriber_account_id);
			$this->load->view('edit_subscriber_account_view', $data);
		} else {
			$user_data = array(
				'email'		=> $this->input->post('email'),
				'password'	=> $this->input->post('password'),
			);
			$user_updated = $this->user_model->update_user($user_id, $user_data);
			if($user_updated) {
				$account_data = array(
					'first_name'		=> $this->input->post('first_name'),
					'last_name'		 	=> $this->input->post('last_name'),
					'company_name'	  	=> $this->input->post('company_name'),
					'website'		   	=> $this->input->post('website'),
					'phone_number'		=> $this->input->post('phone_number'),
					'street_address'	=> $this->input->post('street_address'),
					'city'			  	=> $this->input->post('city'),
					'state'			 	=> $this->input->post('state'),
					'zip_code'		 	=> $this->input->post('zip_code'),
				);
				$account_updated = $this->account_model->update_subscriber_account($subscriber_account_id, $account_data);
				if($account_updated) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("edit_subscriber_account");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("edit_subscriber_account");
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}
	
}




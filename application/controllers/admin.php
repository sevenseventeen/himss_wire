<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('admin_library');
	}

	public function index() {
		if (!$this->auth->logged_in()) {
			redirect('admin/login');
		}
		$this->admin_library->load_admin_view();
	}
	
	/*
	 * 
	 * View Functions
	 * 
	 * 
	 */
	 
	public function subscriber_account($user_id, $subscriber_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->model('subscription_model');
		$this->load->model('content_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['subscriber_account'] = $this->account_model->get_subscriber_by_id($subscriber_account_id);
		$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
		$data['reports'] = $this->content_model->get_reports_by_subscriber_account_id($subscriber_account_id);
		$this->load->view('subscriber_account_admin_view', $data);
	} 
	
	/*
	 * 
	 * Add Functions
	 * 
	 * 
	 */

	public function add_article() {
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$user_id = $this->session->userdata('user_id');
		$this->load->model('content_model');
		$this->load->model('account_model');
		$this->load->model('subscription_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('subscriber_id', 'Subscriber Name', 'required');
		$this->form_validation->set_rules('article_category_id', 'Article Category', 'required');
		$this->form_validation->set_rules('article_title', 'Article Title', 'required');
		$this->form_validation->set_rules('article_summary', 'Article Summary', 'required');
		$this->form_validation->set_rules('article_body', 'Article Body', 'required');
		//$this->form_validation->set_rules('article_status', 'Article Status', 'required');
		$this->form_validation->set_rules('publish_date', 'Publish Date', 'required');
		$this->form_validation->set_rules('article_tags', 'Article Tags', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			$publish_date = $this->input->post('publish_date');
			$publish_date_datetime = new DateTime($publish_date);
			$formatted_publish_date = date_format ($publish_date_datetime, 'Y-m-d');
			$data = array(
				'subscriber_id'			=> $this->input->post('subscriber_id'),
				'article_category_id'	=> $this->input->post('article_category_id'),
				'article_title'			=> $this->input->post('article_title'),
				'article_summary'		=> $this->input->post('article_summary'),
				'article_body'			=> $this->input->post('article_body'),
				'article_status'		=> $this->input->post('article_status'),
				'publish_date'			=> $formatted_publish_date,
				'article_tags'			=> $this->input->post('article_tags')
			);
			$article_added = $this->content_model->add_article($data);
			if ($article_added) {
				$subscriber_account_id = $this->input->post('subscriber_id'); 
				$subscription = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
				$articles_remaining = $subscription[0]->stories_remaining;
				$articles_remaining -= 1;
				$subscription_id = $subscription[0]->subscription_id; 
				$data = array('stories_remaining' => $articles_remaining);
				$subscription_updated = $this->subscription_model->update_subscription($subscription_id, $data);
				if($subscription_updated) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
			} else {
				echo "Failure, with article_added.";
			}
		} 
	}

	public function add_category() {
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$user_id = $this->session->userdata('user_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			$data = array(
				'category_name'	=> $this->input->post('category_name'),
			);
			$category_added = $this->content_model->add_category($data);
			if($category_added) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		} 
	}
	
	public function add_external_account() {
		$account_type_id = $this->input->post('account_type_id');
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'Sorry, that email address is already in use.');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_type_id', 'Account Type', 'required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('website', 'Website', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
		$this->form_validation->set_rules('street_address', 'Street Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			// $email = $this->input->post('email');
			// $this->load->model('auth_model');
			// $user_exists = $this->auth_model->get_user_by_email($email);
			// if ($user_exists) {
				// $data['error'] = "Sorry that email address in already in use.";
				// $this->admin_library->load_admin_view();
			// }
			$user_data = array(
				'account_type_id'	=> $this->input->post('account_type_id'),
				'email'		 		=> $this->input->post('email'),
				'password'			=> $this->input->post('password'),
				'created_on'		=> now()
			);
			$user_created = $this->user_model->add_user($user_data);
			if($user_created) {
				$user_id = $this->db->insert_id();					
				$account_data = array(
					'user_id'			=> $user_id,
					'first_name'		=> $this->input->post('first_name'),
					'last_name'			=> $this->input->post('last_name'),
					'company_name'		=> $this->input->post('company_name'),
					'website'			=> $this->input->post('website'),
					'phone_number'		=> $this->input->post('phone_number'),
					'street_address'	=> $this->input->post('street_address'),
					'city'				=> $this->input->post('city'),
					'state'				=> $this->input->post('state'),
					'zip_code'			=> $this->input->post('zip_code'),
				);
				switch ($account_type_id) {
					case '3':
						$account_created = $this->account_model->add_subscriber($account_data);		
						break;
					case '4':
						$account_created = $this->account_model->add_network_partner($account_data);		
						break;
					default:
						$account_created = FALSE;
						break;
				}
				if($account_created) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}
	
	public function add_internal_account() {
		$account_type_id = $this->input->post('account_type_id');
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_type_id', 'Account Type', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			$user_data = array(
				'account_type_id'	=> $this->input->post('account_type_id'),
				'email'		 		=> $this->input->post('email'),
				'password'	  		=> $this->input->post('password'),
				'created_on'		=> now()
			);
			$user_created = $this->user_model->add_user($user_data);
			if($user_created) {
				$user_id = $this->db->insert_id();					
				$account_data = array(
					'user_id'		=> $user_id,
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name')
				);
				switch ($account_type_id) {
					case '1':
						$account_created = $this->account_model->add_administrator($account_data);		
						break;
					case '2':
						$account_created = $this->account_model->add_editor($account_data);		
						break;
					default:
						$account_created = FALSE;
						break;
				}
				if($account_created) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}

	public function add_subscription_package() {
		$subscriber_account_id = $this->input->post('subscriber_account_id');
		$user_id = $this->input->post('user_id');
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('subscription_model');
		//$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('subscription_summary', 'Subscription Summary', 'required');
		$this->form_validation->set_rules('subscription_details', 'Subscription Details', 'required');
		$this->form_validation->set_rules('stories_purchased', 'Stories Purchased', 'required|numeric');
		$this->form_validation->set_rules('subscription_start', 'Subscription Start Date', 'required');
		$this->form_validation->set_rules('subscription_end', 'Subscription End Date', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			echo "<span class='error'>FALSE</span>";
			$this->load->model('account_model');
			$this->load->model('user_model');
			$this->load->model('subscription_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['subscriber_account'] = $this->account_model->get_subscriber_by_id($subscriber_account_id);
			$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
			$this->load->view('subscriber_account_view', $data);
		} else {
			$subscription_data = array(
				'subscriber_account_id'		=> $this->input->post('subscriber_account_id'),
				'subscription_summary'		=> $this->input->post('subscription_summary'),
				'subscription_details'		=> $this->input->post('subscription_details'),
				'stories_purchased'	  		=> $this->input->post('stories_purchased'),
				'stories_remaining'	  		=> $this->input->post('stories_purchased'),
				'subscription_start_date'	=> $this->input->post('subscription_start'),
				'subscription_end_date'	  	=> $this->input->post('subscription_end'),
				'created_on'				=> now()
			);
			$subscription_created = $this->subscription_model->add_subscription($subscription_data);
			if($subscription_created) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		}
	}

	public function add_footer_link() {
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('footer_link_text', 'Footer Link Text', 'required');
		$this->form_validation->set_rules('footer_link_url', 'Footer Link Url', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			$footer_link_data = array(
				'footer_link_text'		=> $this->input->post('footer_link_text'),
				'footer_link_url'		=> $this->input->post('footer_link_url'),
			);
			$footer_link_created = $this->content_model->add_footer_link($footer_link_data);
			if($footer_link_created) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		}
	}

	public function add_faq() {
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('faq_question', 'FAQ Question Text', 'required');
		$this->form_validation->set_rules('faq_answer', 'FAQ Answer', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->admin_library->load_admin_view();
		} else {
			$faq_data = array(
				'faq_question'		=> $this->input->post('faq_question'),
				'faq_answer'		=> $this->input->post('faq_answer'),
			);
			$faq_created = $this->content_model->add_faq($faq_data);
			if($faq_created) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		}
	}
	
	function add_report() {
		$subscriber_account_id = $this->input->post('subscriber_account_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('report_title', 'Report Title', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			$config['upload_path'] = './_reports/';
			$config['allowed_types'] = 'pdf';
			$config['file_name'] = now();
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()) {
				// TODO Set custom error system here.
				//$error = array('error' => $this->upload->display_errors());
				//$this->load->view('upload_form', $error);
			} else {
				$image_data = $this->upload->data();
				$report_data = array(
					'subscriber_account_id'	=> $subscriber_account_id,
					'report_title'			=> $this->input->post('report_title'),
					'report_path'			=> $image_data['file_name']
				);
				echo "Sub ACCT ID: $subscriber_account_id<br />";
				echo "Tit: ".$report_data['report_title']."<br />";
				echo "NAme: ".$report_data['report_path']."<br />";
				$report_added = $this->content_model->add_report($report_data);
				if($report_added) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
			}
		}
	}


	/*
	 * 
	 * Edit Functions
	 * 
	 * 
	 */
	
	public function edit_subscriber_account($user_id, $subscriber_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->model('subscription_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['subscriber_account'] = $this->account_model->get_subscriber_by_id($subscriber_account_id);
		$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
		$this->load->view('edit_subscriber_account_view', $data);
	}
	
	public function edit_network_partner_account($user_id, $network_partner_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['network_partner_account'] = $this->account_model->get_network_partner_by_id($network_partner_account_id);
		$this->load->view('edit_network_partner_account_view', $data);
	}
	
	public function edit_article($article_id) {
		$this->load->model('content_model');
		$data['article'] = $this->content_model->get_article_by_id($article_id);
		$data['categories'] = $this->content_model->get_categories();
		$this->load->view('edit_article_view', $data);
	}
	
	public function edit_category($category_id) {
		$this->load->model('content_model');
		$data['category'] = $this->content_model->get_category_by_id($category_id);
		$this->load->view('edit_category_view', $data);
	}
	
	public function edit_static_page($page_id) {
		$this->load->model('content_model');
		$data['static_page'] = $this->content_model->get_static_page_by_id($page_id);
		$data['static_page_content'] = $this->content_model->get_static_page_content_by_id($page_id);
		$this->load->view('edit_static_page_view', $data);
	}
	
	public function edit_admin_account($user_id, $admin_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['admin_account'] = $this->account_model->get_admin_account_by_id($admin_account_id);
		$this->load->view('edit_admin_account_view', $data);
	}
	
	public function edit_editor_account($user_id, $editor_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['editor_account'] = $this->account_model->get_editor_account_by_id($editor_account_id);
		$this->load->view('edit_editor_account_view', $data);
	}
	
	/*
	 * 
	 * Login Functions
	 * 
	 * 
	 */
	
	public function login() {
		$this->load->view('login_view');
	}
	 
	public function login_user() {
		$this->load->model('auth_model');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$logged_in = $this->auth_model->login($email, $password);
		if ($logged_in) {
			$user_id = $this->session->userdata('user_id');
			switch ($this->auth->user_type()) {
				case "Administrator":
					redirect('admin');
					break;
				case "Editor":
					redirect('admin');
					break;
				case "Network Partner":
					redirect("network_partner/$user_id");
					break;
				default:
					redirect("subscriber/$user_id");
					break;
			}
		} else {
			$this->load->view('logged_out_view');
		}
	}
	
	public function logout() {
		$this->load->model('auth_model');
		$this->auth_model->logout();
		$this->load->view('logged_out_view');
	}
	
	/*
	 * 
	 * Update Functions
	 * 
	 * 
	 */
	
	public function update_article() {
		$article_id = $this->input->post('article_id');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('article_title', 'Article Title', 'required');
		$this->form_validation->set_rules('article_summary', 'Article Summary', 'required');
		$this->form_validation->set_rules('article_body', 'Article Body', 'required');
		$this->form_validation->set_rules('article_status', 'Published Status', 'required');
		$this->form_validation->set_rules('article_tags', 'Article Tags', 'required');
		$this->form_validation->set_rules('article_category_id', 'Article Category', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('content_model');
			$data['article'] = $this->content_model->get_article_by_id($article_id);
			$data['categories'] = $this->content_model->get_categories();
			$this->load->view('edit_article_view', $data);
		} else {
			$article_data = array(
				'article_title'		=> $this->input->post('article_title'),
				'article_summary'	=> $this->input->post('article_summary'),
				'article_body'	  	=> $this->input->post('article_body'),
				'article_status'	=> $this->input->post('article_status'),
				'article_tags'		=> $this->input->post('article_tags'),
			);
			$article_updated = $this->content_model->update_article($article_id, $article_data);
			if($article_updated) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin/edit_article/$article_id");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin/edit_article/$article_id");
			}
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
				if ($account_updated) {
					echo "Success, with account_updated.";
					//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
					//redirect("site/edit_vehicle/");
				} else {
					echo "Failure, with account_updated.";
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}
	
	public function update_network_partner_account() {
		$network_partner_account_id = $this->input->post('network_partner_account_id');
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
			$data['network_partner_account'] = $this->account_model->get_network_partner_by_id($network_partner_account_id);
			$this->load->view('edit_network_partner_account_view', $data);
		} else {
			$user_data = array(
				'email'		 => $this->input->post('email'),
				'password'	  => $this->input->post('password'),
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
				$account_updated = $this->account_model->update_network_partner_account($network_partner_account_id, $account_data);
				if ($account_updated) {
					echo "Success, with account_updated.";
					//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
					//redirect("site/edit_vehicle/");
				} else {
					echo "Failure, with account_updated.";
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}
	
	public function update_admin_account() {
		$admin_account_id = $this->input->post('admin_account_id');
		$user_id = $this->input->post('user_id');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('account_model');
			$this->load->model('user_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['admin_account'] = $this->account_model->get_admin_account_by_id($admin_account_id);
			$this->load->view('edit_admin_account_view', $data);
		} else {
			$user_data = array(
				'email'		=> $this->input->post('email'),
				'password'	=> $this->input->post('password'),
			);
			$user_updated = $this->user_model->update_user($user_id, $user_data);
			if($user_updated) {
				$account_data = array(
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
				);
				$account_updated = $this->account_model->update_admin_account($admin_account_id, $account_data);
				if ($account_updated) {
					echo "Success, with account_updated.";
					//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
					//redirect("site/edit_vehicle/");
				} else {
					echo "Failure, with account_updated.";
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}
	
	public function update_editor_account() {
		$editor_account_id = $this->input->post('editor_account_id');
		$user_id = $this->input->post('user_id');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('account_model');
			$this->load->model('user_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['editor_account'] = $this->account_model->get_editor_account_by_id($editor_account_id);
			$this->load->view('edit_editor_account_view', $data);
		} else {
			$user_data = array(
				'email'		=> $this->input->post('email'),
				'password'	=> $this->input->post('password'),
			);
			$user_updated = $this->user_model->update_user($user_id, $user_data);
			if($user_updated) {
				$account_data = array(
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
				);
				$account_updated = $this->account_model->update_editor_account($editor_account_id, $account_data);
				if ($account_updated) {
					echo "Success, with account_updated.";
					//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
					//redirect("site/edit_vehicle/");
				} else {
					echo "Failure, with account_updated.";
				}
			} else {
				echo "Failure, with user_created.";
			} 
		}
	}

	public function update_category() {
		$category_id = $this->input->post('article_category_id');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('category_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('content_model');
			$data['category'] = $this->content_model->get_category_by_id($category_id);
			$this->load->view('edit_category_view', $data);
		} else {
			$category_data = array(
				'category_name'	=> $this->input->post('category_name')
			);
			$category_updated = $this->content_model->update_category($category_id, $category_data);
			if ($category_updated) {
				echo "Success, with category_updated.";
				//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
				//redirect("site/edit_vehicle/");
			} else {
				echo "Failure, with category_updated.";
			}
		}
	}

	public function update_subscription() {
		$subscription_id = $this->input->post('subscription_id');
		$user_id = $this->input->post('user_id');
		date_default_timezone_set('UTC');
		if (!$this->auth->logged_in()) {
			redirect('login');
		}
		$this->load->model('subscription_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('subscription_summary', 'Subscription Summary', 'required');
		$this->form_validation->set_rules('subscription_details', 'Subscription Details', 'required');
		$this->form_validation->set_rules('stories_purchased', 'Stories Purchased', 'required');
		$this->form_validation->set_rules('subscription_start', 'Subscription Start Date', 'required');
		$this->form_validation->set_rules('subscription_end', 'Subscription End Date', 'required');
		if ($this->form_validation->run() == FALSE) { // FALSE FOR PRODUCTION
			$this->load->model('account_model');
			$this->load->model('user_model');
			$this->load->model('subscription_model');
			$data['user_account'] = $this->user_model->get_user_by_id($user_id);
			$data['subscriber_account'] = $this->account_model->get_subscriber_by_id($subscriber_account_id);
			$data['subscription_details'] = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
			$this->load->view('subscriber_account_view', $data);
		} else {
			$subscription_data = array(
				'subscriber_account_id'		=> $this->input->post('subscriber_account_id'),
				'subscription_summary'		=> $this->input->post('subscription_summary'),
				'subscription_details'		=> $this->input->post('subscription_details'),
				'stories_purchased'	  		=> $this->input->post('stories_purchased'),
				'subscription_start_date'	=> $this->input->post('subscription_start'),
				'subscription_end_date'	  	=> $this->input->post('subscription_end'),
				'created_on'				=> now()
			);
			$subscription_updated = $this->subscription_model->update_subscription($subscription_id, $subscription_data);
			if($subscription_updated) {
				echo "Success, with subscription_updated.";
				//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
				//redirect("site/edit_vehicle/");
			} else {
				echo "Failure, with subscription_updated.";
			}
		}
	}

	function update_feature_module() {
		$module_entry_id = $this->input->post('module_entry_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('module_text', 'Module Text', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			$config['upload_path'] = './_uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['overwrite']  = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()) {
				// TODO Set custom error system here.
				//$error = array('error' => $this->upload->display_errors());
				//$this->load->view('upload_form', $error);
			} else {
				$image_data = $this->upload->data();
				$module_data = array(
					'module_text'	=> $this->input->post('module_text'),
					'module_image'	=> $image_data['file_name']
				);
				$module_updated = $this->content_model->update_feature_module($module_entry_id, $module_data);
				if($module_updated) {
					echo "Success, with update_module.";
					//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
					//redirect("site/edit_vehicle/");
				} else {
					echo "Failure, with update_module.";
				}
			}
		}
	}

	function update_banner_ad() {
		$banner_ad_id = $this->input->post('banner_ad_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('module_text', 'Module Text', 'required');
		$config['upload_path'] = './_uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  =  TRUE;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload("banner_image")) {
			// TODO Set custom error system here.
			//$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
		} else {
			$image_data = $this->upload->data();
			$banner_data = array(
				'banner_image_path'	=> $image_data['file_name']
			);
			$banner_updated = $this->content_model->update_banner_ad($banner_ad_id, $banner_data);
			if($banner_updated) {
				echo "Success, with update_banner_ad.";
				//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
				//redirect("site/edit_vehicle/");
			} else {
				echo "Failure, with update_banner_ad.";
			}
		}
	}

	function update_static_page() {
		$static_page_id = $this->input->post('static_page_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('page_name', 'Page Name', 'required');
		$this->form_validation->set_rules('page_content', 'Page Content Text', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			$content_data = array(
				'content'	=> $this->input->post('page_content'),
			);
			$name_data = array(
				'page_name'		=> $this->input->post('page_name'),
			);
			$page_updated = $this->content_model->update_static_page($static_page_id, $content_data, $name_data);
			if($page_updated) {
				echo "Success, with update_static_page.";
				//$this->session->set_flashdata('message', 'Success! Your listing has been updated.');
				//redirect("site/edit_vehicle/");
			} else {
				echo "Failure, with update_static_page.";
			}
		}
	}
	
}
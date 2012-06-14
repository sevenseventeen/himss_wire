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
		$data['articles'] = $this->content_model->get_all_articles_by_account_id($subscriber_account_id);
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
		date_default_timezone_set('America/New_York');
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
		$this->form_validation->set_rules('article_tags', 'Article Tags', 'required');
		$this->form_validation->set_rules('draft_status', 'Draft Status', 'trim');
		if ($this->input->post('draft_status') != "true") {
			$this->form_validation->set_rules('publish_date', 'Publish Date', 'required');	
		}
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			if ($this->input->post('draft_status') == "true") {
				$article_status = "Draft";
				$publish_date_formatted_for_unix_conversion = "0000-00-00 00:00:00";
			} else {
				/* 
				 * 
				 * TODO - This is incredibly convoluted and should be re-worked.
				 * The publish date comes from jQuery in m/d/y format.
				 * That then needs to be converted to DateTime so we can format it to Y-m-d h:i:s A
				 * which is the required format for the human_to_unix function. We need the publish date in unix
				 * so we can compare it with time() (which gives a unix formatted number for now.)
				 * 
				 * As mentioned above we're comparing the publish date to the time() now, but
				 * this causes a problem when the publish date is today. This is because the publish date 
				 * contains only a date and so the time portion defaults to 12:00 AM. When we compare now() 
				 * with the publish date with the <= operator, now will always appear larger becasue it contains the time portion. 
				 * To get around that - again, this should be reworked - we take now() and convert it to date time, but without 
				 * the time portion. That is, just 'Y-m-d' which strips off the time portion. Then we convert the date only 
				 * back to a DateTime object, format it as 'Y-m-d h:i:s A' so it can be converted to unix and finally compared. Gross.
				 *   
				 *  
				 */  
				$publish_date = $this->input->post('publish_date');
				$publish_date_as_datetime = new DateTime($publish_date);
				$publish_date_formatted_for_unix_conversion = date_format ($publish_date_as_datetime, 'Y-m-d h:i:s A');
				$publish_date_unix = human_to_unix($publish_date_formatted_for_unix_conversion);
				$now = time();
				// TODO move this garbage into the custom helper function 
				$human_now = unix_to_human($now);
				$now_as_datetime = new DateTime($human_now);
				$now_without_time = date_format($now_as_datetime, 'Y-m-d');
				$now_as_datetime_without_time = new DateTime($now_without_time);
				$now_as_datetime_without_time_formatted = date_format($now_as_datetime_without_time, 'Y-m-d h:i:s A');
				$now_as_unix_without_seconds = human_to_unix($now_as_datetime_without_time_formatted);
				if ($publish_date_unix <= $now_as_unix_without_seconds) {
					$article_status = "Published";
				} else {
					$article_status = "Pending";
				}
			} 
			$data = array(
				'subscriber_id'			=> $this->input->post('subscriber_id'),
				'article_category_id'	=> $this->input->post('article_category_id'),
				'article_title'			=> $this->input->post('article_title'),
				'article_summary'		=> $this->input->post('article_summary'),
				'article_body'			=> $this->input->post('article_body'),
				'article_status'		=> $article_status,
				'publish_date'			=> $publish_date_formatted_for_unix_conversion,
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
		$this->load->library('form_validation');
		$websites = $this->input->post('websites'); 
		if(!empty($websites)) {
			array_filter($websites);
		} else {
			$this->form_validation->set_rules('websites[]', 'Website', 'trim|required');	
		}
		
		$this->load->model('account_model');
		$this->load->model('user_model');
		$this->form_validation->set_message('is_unique', 'Sorry, that email address is already in use.');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_type_id', 'Account Type', 'required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		//$this->form_validation->set_rules('websites[]', 'Website', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
		$this->form_validation->set_rules('street_address', 'Street Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|numeric');
		$this->form_validation->set_rules('welcome_email', 'Welcome Email', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required');
		$websites = $this->input->post('websites');
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view($websites);
		} else {
			$user_data = array(
				'account_type_id'	=> $this->input->post('account_type_id'),
				'email'		 		=> $this->input->post('email'),
				'password'			=> $this->input->post('password'),
				'created_on'		=> now()
			);
			$user_created = $this->user_model->add_user($user_data);
			if($user_created) {
				if ($this->input->post('welcome_email') == 'true') {
					$name = $this->input->post('name');
					$email = $this->input->post('email');
					$password = $this->input->post('password');
					$message = "Congratulations, we have activated your HIMSS Wire account. You can login anytime with the following information\n\n Email: $email \n\n Password: $password";
		            $to = $this->input->post('email');
					$from_email = $this->config->item('email_from_support');
					$from_name = $this->config->item('email_name_from_admin');
					$this->load->library('email');
			        $this->email->from($from_email, $from_name);
			        $this->email->to($to);
			        $this->email->subject('Your HIMSS Wire Account');
			        $this->email->message($message);
					if ($this->email->send()) {
						// Sent
			        } else {
			        	// Not Sent
			        }
				}
				$user_id = $this->db->insert_id();					
				$account_data = array(
					'user_id'			=> $user_id,
					'first_name'		=> $this->input->post('first_name'),
					'last_name'			=> $this->input->post('last_name'),
					'company_name'		=> $this->input->post('company_name'),
					
					'phone_number'		=> $this->input->post('phone_number'),
					'street_address'	=> $this->input->post('street_address'),
					'city'				=> $this->input->post('city'),
					'state'				=> $this->input->post('state'),
					'zip_code'			=> $this->input->post('zip_code'),
				);
				
				//'website'			=> $this->input->post('website'),
				switch ($account_type_id) {
					case '3':
						$account_created = $this->account_model->add_subscriber($account_data);		
						break;
					case '4':
						$account_created = $this->account_model->add_network_partner($account_data);
						foreach ($websites as $website) {
							//echo "Site: $website <br />";
							$website_data = array(
								'user_id'	=> $user_id,
								'url'		=> $website
							);
							$this->account_model->add_websites($website_data);
						}		
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
		$this->form_validation->set_rules('footer_link_url', 'Footer Link Url', 'required|prep_url');
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
				//echo "Sub ACCT ID: $subscriber_account_id<br />";
				//echo "Tit: ".$report_data['report_title']."<br />";
				//echo "NAme: ".$report_data['report_path']."<br />";
				$report_added = $this->content_model->add_report($report_data);
				if($report_added) {
					echo "Success (this should redirect to edit subscriber page)";
					//$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					//redirect("admin");
				} else {
					echo "Failure - admin.php, line 389.";
					//$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					//redirect("admin");
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
		$this->load->view('edit_subscriber_account_admin_view', $data);
	}
	
	public function edit_network_partner_account($user_id, $network_partner_account_id) {
		$this->load->model('account_model');
		$this->load->model('user_model');
		$data['user_account'] = $this->user_model->get_user_by_id($user_id);
		$data['network_partner_account'] = $this->account_model->get_network_partner_by_user_id($user_id);
		$this->load->view('edit_network_partner_account_admin_view', $data);
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
	
	public function edit_footer_link($footer_link_id) {
		$this->load->model('content_model');
		$data['footer_link'] = $this->content_model->get_footer_link_by_id($footer_link_id);
		$this->load->view('edit_footer_link_view', $data);
	}
	
	public function edit_faq($faq_id) {
		$this->load->model('content_model');
		$data['faq'] = $this->content_model->get_faq_by_id($faq_id);
		$this->load->view('edit_faq_view', $data);
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
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
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
			if($category_updated) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
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
		$this->form_validation->set_rules('stories_purchased', 'Stories Purchased', 'required|integer');
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
		$feature_module_id = $this->input->post('feature_module_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('module_text', 'Module Text', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			$module_data = array('module_text'	=> $this->input->post('module_text'));
			$module_updated = $this->content_model->update_feature_module($feature_module_id, $module_data);
			if($module_updated) {
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		}
	}

	function update_banner_ad() {
		$banner_ad_id = $this->input->post('banner_ad_id');
		$this->load->model('content_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('banner_url', 'Banner URL', 'required');
		$config['upload_path'] = './_uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  =  TRUE;
		$this->load->library('upload', $config);
		if ($this->form_validation->run() == FALSE) {
			$this->admin_library->load_admin_view();
		} else {
			if (!$this->upload->do_upload("banner_image")) {
				// TODO Set custom error system here.
				//$error = array('error' => $this->upload->display_errors());
				//$this->load->view('upload_form', $error);
			} else {
				$image_data = $this->upload->data();
				$banner_data = array(
					'banner_image_path'	=> $image_data['file_name'],
					'banner_url'		=> $this->input->post('banner_url')
				);
				$banner_updated = $this->content_model->update_banner_ad($banner_ad_id, $banner_data);
				if($banner_updated) {
					$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
					redirect("admin");
				} else {
					$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
					redirect("admin");
				}
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
				$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
				redirect("admin");
			} else {
				$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
				redirect("admin");
			}
		}
	}

	public function update_footer_link() {
		$footer_link_id = $this->input->post('footer_link_id');
		$this->load->model('content_model');
		$footer_link_data = array(
				'footer_link_text'	=> $this->input->post('footer_link_text'),
				'footer_link_url'	=> $this->input->post('footer_link_url')
			);
		$footer_link_updated = $this->content_model->update_footer_link($footer_link_id, $footer_link_data);
		if($footer_link_updated) {
			$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
			redirect("admin");
		} else {
			$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
			redirect("admin");
		}
	}

	public function update_faq() {
		$faq_id = $this->input->post('faq_id');
		$this->load->model('content_model');
		$faq_data = array(
				'faq_question'	=> $this->input->post('faq_question'),
				'faq_answer'	=> $this->input->post('faq_answer')
			);
		$faq_updated= $this->content_model->update_faq($faq_id, $faq_data);
		if($faq_updated) {
			$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
			redirect("admin");
		} else {
			$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
			redirect("admin");
		}
	}

	/*
	 * 
	 * Delete Functions
	 * 
	 * 
	 */
	 
	 function delete_article($article_id) {
		$this->load->model('content_model');
		$article_deleted = $this->content_model->delete_article($article_id);
		if($article_deleted) {
			$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
			redirect("admin");
		} else {
			$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
			redirect("admin");
		}
	 }	
	 
	 function delete_footer_link($footer_link_id) {
		$this->load->model('content_model');
		$footer_link_deleted = $this->content_model->delete_footer_link($footer_link_id);
		if($footer_link_deleted) {
			$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
			redirect("admin");
		} else {
			$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
			redirect("admin");
		}
	 }	
	 
	 function delete_faq($faq_id) {
		$this->load->model('content_model');
		$faq_deleted = $this->content_model->delete_faq($faq_id);
		if($faq_deleted) {
			$this->session->set_flashdata('message', 'Success! Your edits have been saved.');
			redirect("admin");
		} else {
			$this->session->set_flashdata('message', 'Sorry, there was a problem saving your edits.');
			redirect("admin");
		}
	 }	
}
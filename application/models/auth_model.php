<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Auth_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
		$this->load->helper('date');
		$this->load->library('session');
	}
	
	public function login($email, $password) {
		if (empty($email) || empty($password)) {
			return FALSE;
		}
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get();
		$result = $query->row();
		if ($query->num_rows() == 1) {
			// TODO Set up encription
			//$password = $this->hash_password_db($password);
			//$password = $this->$password;
			if ($result->password === $password) {
				$session_data = array(
					'user_id' => $result->user_id
				);
				//'account_type'  => $result->account_type
				$this->session->set_userdata($session_data);
				return TRUE;
			}
		}
		echo "Failed Login";
		return FALSE;
	}
	
	public function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
		return TRUE;
	}
	
	public function logged_in() {
		return (bool) $this->session->userdata('user_id');
	}

	public function hash_password($password) {
		if (empty($password)) {
			return FALSE;
		}
		$salt = $this->salt();
		return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
	}

	/**
	 * This function takes a password and validates it
	 * against an entry in the users table.
	 * 
	 **/
	
	public function hash_password_db($password) {
		if (empty($password)) {
			return FALSE;
		}

	   $query = $this->db->select('password')
				 ->select('salt')
				 ->where($this->identity_column, $identity)
				 ->where($this->ion_auth->_extra_where)
				 ->limit(1)
				 ->get($this->tables['users']);

		$result = $query->row();

		if ($query->num_rows() !== 1)
		{
		return FALSE;
		}

		if ($this->store_salt)
		{
		return sha1($password . $result->salt);
		}
		else
		{
		$salt = substr($result->password, 0, $this->salt_length);

		return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	/**
	 * Generates a random salt value.
	 * 
	 */
	
	public function salt() {
		return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
	}

	/**
	 * Activation functions
	 *
	 * Activate : Validates and removes activation code.
	 * Deactivae : Updates a users row with an activation code.
	 *
	 * @author Mathew
	 */

	/**
	 * activate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($id, $code = false)
	{
		if ($code !== false)
		{
			$query = $this->db->select($this->identity_column)
					  ->where('activation_code', $code)
					  ->limit(1)
					  ->get($this->tables['users']);

			$result = $query->row();

			if ($query->num_rows() !== 1)
			{
				return FALSE;
			}

			$identity = $result->{$this->identity_column};

			$data = array(
					'activation_code' => '',
					'active'	  => 1
					 );

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
		}
		else
		{
			$data = array(
					'activation_code' => '',
					'active' => 1
					 );

			$this->db->where($this->ion_auth->_extra_where);
			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}

		return $this->db->affected_rows() == 1;
	}


	/**
	 * Deactivate
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id = 0)
	{
		if (empty($id))
		{
		return FALSE;
		}

		$activation_code	   = sha1(md5(microtime()));
		$this->activation_code = $activation_code;

		$data = array(
			'activation_code' => $activation_code,
			'active'	  => 0
		);

		$this->db->where($this->ion_auth->_extra_where);
		$this->db->update($this->tables['users'], $data, array('id' => $id));

		return $this->db->affected_rows() == 1;
	}

	/**
	 * change password
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
		$query = $this->db->select('password, salt')
				  ->where($this->identity_column, $identity)
				  ->where($this->ion_auth->_extra_where)
				  ->limit(1)
				  ->get($this->tables['users']);

		$result = $query->row();

		$db_password = $result->password;
		$old	 = $this->hash_password_db($identity, $old);
		$new	 = $this->hash_password($new, $result->salt);

		if ($db_password === $old)
		{
			//store the new password and reset the remember code so all remembered instances have to re-login
		$data = array(
				'password' => $new,
				'remember_code' => '',
				 );

		$this->db->where($this->ion_auth->_extra_where);
		$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));

		return $this->db->affected_rows() == 1;
		}

		return FALSE;
	}

	/**
	 * Checks username
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function username_check($username = '')
	{
		if (empty($username))
		{
		return FALSE;
		}

		return $this->db->where('username', $username)
				->where($this->ion_auth->_extra_where)
				->count_all_results($this->tables['users']) > 0;
	}

	/**
	 * Checks email
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function email_check($email = '') {
		if (empty($email)) {
			return FALSE;
		}
		return $this->db->where('email', $email)
						->where($this->ion_auth->_extra_where)
						->count_all_results($this->tables['users']) > 0;
	}


	/**
	 * Insert a forgotten password key.
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function forgotten_password($email = '')
	{
		if (empty($email))
		{
		return FALSE;
		}

		$key = $this->hash_password(microtime().$email);

		$this->forgotten_password_code = $key;

		$this->db->where($this->ion_auth->_extra_where);

		$this->db->update($this->tables['users'], array('forgotten_password_code' => $key), array('email' => $email));

		return $this->db->affected_rows() == 1;
	}
	
	
	
	/**
	 * Forgotten Password Complete
	 *
	 * @return string
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code, $salt=FALSE)
	{
		if (empty($code))
		{
		return FALSE;
		}

		$this->db->where('forgotten_password_code', $code);

		if ($this->db->count_all_results($this->tables['users']) > 0)
		{
		$password = $this->salt();

		$data = array(
				'password'			=> $this->hash_password($password, $salt),
				'forgotten_password_code'   => '0',
				'active'			=> 1,
				 );

		$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

		return $password;
		}

		return FALSE;
	}

	/**
	 * profile
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function profile($identity = '', $is_code = false)
	{
		if (empty($identity))
		{
		return FALSE;
		}

		$this->db->select(array(
				$this->tables['users'].'.*',
				$this->tables['groups'].'.name AS '. $this->db->protect_identifiers('group'),
				$this->tables['groups'].'.description AS '. $this->db->protect_identifiers('group_description')
				   ));

		if (!empty($this->columns))
		{
		foreach ($this->columns as $field)
		{
			$this->db->select($this->tables['meta'] .'.' . $field);
		}
		}

		$this->db->join($this->tables['meta'], $this->tables['users'].'.id = '.$this->tables['meta'].'.'.$this->meta_join, 'left');
		$this->db->join($this->tables['groups'], $this->tables['users'].'.group_id = '.$this->tables['groups'].'.id', 'left');

		if ($is_code)
		{
		$this->db->where($this->tables['users'].'.forgotten_password_code', $identity);
		}
		else
		{
		$this->db->where($this->tables['users'].'.'.$this->identity_column, $identity);
		}

		$this->db->where($this->ion_auth->_extra_where);

		$this->db->limit(1);
		$i = $this->db->get($this->tables['users']);

		return ($i->num_rows > 0) ? $i->row() : FALSE;
	}

	/**
	 * Basic functionality
	 *
	 * Register
	 * Login
	 *
	 * @author Mathew
	 */

	/**
	 * register
	 *
	 * @return bool
	 * @author Mathew
	 **/
	public function register_buyer($first_name, $account_type, $last_name, $email, $password, $additional_data = false) {
		if ($this->identity_column == 'email' && $this->email_check($email)) {
			$this->ion_auth->set_error('account_creation_duplicate_email');
			return FALSE;
		} 
		
		// IP Address
		
		$ip_address = $this->input->ip_address();
		$salt	= $this->store_salt ? $this->salt() : FALSE;
		$password	= $this->hash_password($password, $salt);

		// Users table.
		
		$data = array(
			'account_type'	=> $account_type,
			'first_name' 	=> $first_name,
			'last_name'  	=> $last_name,
			'password'   	=> $password,
			'email'	  	=> $email,
			'ip_address' 	=> $ip_address,
			'created_on'	=> now(),
			'last_login' 	=> now(),
			'active'	 	=> 1, 
			'approved'		=> 'pending'
			 );

		if ($this->store_salt) {
			$data['salt'] = $salt;
		}

		if($this->ion_auth->_extra_set) {
			$this->db->set($this->ion_auth->_extra_set);
		}

		$this->db->insert($this->tables['users'], $data);
		
		
		// Buyer Accounts Table
		
		$id = $this->db->insert_id();
		
		$data = array(	'user_id'							=> $id,
						'dealer_name'						=> $additional_data['dealer_name'],
						'title'								=> $additional_data['title'],
						'business_street_address'			=> $additional_data['business_street_address'],
						'business_city'						=> $additional_data['business_city'],
						'business_state'					=> $additional_data['business_state'],
						'business_zip_code'					=> $additional_data['business_zip_code'],
						'license_number'					=> $additional_data['license_number'],
						'insurance_company_name'			=> $additional_data['insurance_company_name'],
						'insurance_company_contact_name'	=> $additional_data['insurance_company_contact_name'],
						'insurance_company_contact_phone'	=> $additional_data['insurance_company_contact_phone'],
						'insurance_policy_number'			=> $additional_data['insurance_policy_number'],
						'bank_name'							=> $additional_data['bank_name'],
						'bank_contact_name'					=> $additional_data['bank_contact_name'],
						'bank_contact_phone'				=> $additional_data['bank_contact_phone'],
						'business_telephone_number'			=> $additional_data['business_telephone_number']//,
						//'payment_type'						=> $additional_data['payment_type'],
						//'card_number'						=> $additional_data['card_number'],
						//'cvv'								=> $additional_data['cvv'],
						//'card_expiration_month'				=> $additional_data['card_expiration_month'],
						//'card_expiration_year'				=> $additional_data['card_expiration_year']
						 );

		$this->db->insert($this->tables['buyers_accounts'], $data);

		return $this->db->affected_rows() > 0 ? $id : false;
		
		
	}
	
	public function update_buyer_account($first_name, $account_type, $last_name, $email, $additional_data = false) {
	   
		// Updates Users Table 
		
		$data = array(
						'account_type'	=> $account_type,
						'first_name' 	=> $first_name,
						'last_name'  	=> $last_name,
						'email'	  	=> $email,
			 		);

		$this->db->where('id', $additional_data['user_id']);
		$result = $this->db->update('users', $data);
			
		 // Updates Buyers Accounts Table
		
		$data = array(	'user_id'							=> $additional_data['user_id'],
						'dealer_name'						=> $additional_data['dealer_name'],
						'title'								=> $additional_data['title'],
						'business_street_address'			=> $additional_data['business_street_address'],
						'business_city'						=> $additional_data['business_city'],
						'business_state'					=> $additional_data['business_state'],
						'business_zip_code'					=> $additional_data['business_zip_code'],
						'license_number'					=> $additional_data['license_number'],
						'insurance_company_name'			=> $additional_data['insurance_company_name'],
						'insurance_company_contact_name'	=> $additional_data['insurance_company_contact_name'],
						'insurance_company_contact_phone'	=> $additional_data['insurance_company_contact_phone'],
						'insurance_policy_number'			=> $additional_data['insurance_policy_number'],
						'bank_name'							=> $additional_data['bank_name'],
						'bank_contact_name'					=> $additional_data['bank_contact_name'],
						'bank_contact_phone'				=> $additional_data['bank_contact_phone'],
						'business_telephone_number'			=> $additional_data['business_telephone_number'],
						
					);

		$this->db->where('user_id', $additional_data['user_id']);
		$result = $this->db->update($this->tables['buyers_accounts'], $data);
		return $result;
	}

	public function update_seller_account($first_name, $account_type, $last_name, $email, $additional_data = false) {
	   
		// Updates Users Table 
		
		$data = array(
						'account_type'	=> $account_type,
						'first_name' 	=> $first_name,
						'last_name'  	=> $last_name,
						'email'	  	=> $email,
			 		);
		
		
		$this->db->where('id', $additional_data['user_id']);
		$result = $this->db->update('users', $data);
		
		
		//$this->db->update($this->tables['users'], $data);
		
		 // Updates Buyers Accounts Table
		
		$data = array(	
						'user_id'							=> $additional_data['user_id'],
						'title'								=> $additional_data['title'],
						'business_name'						=> $additional_data['business_name'],
						'business_street_address'			=> $additional_data['business_street_address'],
						'business_city'						=> $additional_data['business_city'],
						'business_state'					=> $additional_data['business_state'],
						'business_zip_code'					=> $additional_data['business_zip_code'],
						'fax_number'						=> $additional_data['fax_number'],
						'telephone_number'					=> $additional_data['telephone_number'],
						
					);

		$this->db->where('user_id', $additional_data['user_id']);
		$result = $this->db->update($this->tables['sellers_accounts'], $data);
		return $result;
	}

	public function update_buyer_password ($password, $user_id) {
		
		// To do - need to check if user_id exists first 
		$query = $this->db->query("SELECT * FROM users where id='$user_id'");
		if($query->num_rows()>0) {
			$password	= $this->hash_password($password);
			$data = array('password' => $password);
			$this->db->where('id', $user_id);
			$result = $this->db->update('users', $data);
			return $result;
		} else {
			return false;
		}
	}
	
	public function update_seller_password ($password, $user_id) {
		
		// To do - need to check if user_id exists first 
		$query = $this->db->query("SELECT * FROM users where id='$user_id'");
		if($query->num_rows()>0) {
			$password	= $this->hash_password($password);
			$data = array('password' => $password);
			$this->db->where('id', $user_id);
			$result = $this->db->update('users', $data);
			return $result;
		} else {
			return false;
		}
	}
	
	public function update_forgotten_password ($password, $forgotten_password_code) {
		
		
		$query = $this->db->query("SELECT * FROM users where forgotten_password_code='$forgotten_password_code'");
		if($query->num_rows()>0) {
			$password	= $this->hash_password($password);
			$data = array('password' => $password);
			$this->db->where('forgotten_password_code', $forgotten_password_code);
			$result = $this->db->update('users', $data);
			return $result;
		} else {
			return false;
		}
	}

	public function register_seller($first_name, $account_type, $last_name, $email, $password, $additional_data = false) {
		if ($this->identity_column == 'email' && $this->email_check($email)) {
			$this->ion_auth->set_error('account_creation_duplicate_email');
			return FALSE;
		} 
		$ip_address = $this->input->ip_address();
		$salt	= $this->store_salt ? $this->salt() : FALSE;
		$password	= $this->hash_password($password, $salt);
		$data = array(
			'account_type'	=> $account_type,
			'first_name' 	=> $first_name,
			'last_name'  	=> $last_name,
			'password'   	=> $password,
			'email'	  	=> $email,
			'ip_address' 	=> $ip_address,
			'created_on' 	=> now(),
			'last_login' 	=> now(),
			'active'	 	=> 1,
			'approved'		=> 'approved'
			 );

		if ($this->store_salt) {
			$data['salt'] = $salt;
		}

		if($this->ion_auth->_extra_set) {
			$this->db->set($this->ion_auth->_extra_set);
		}

		$this->db->insert($this->tables['users'], $data);
		
		
		// Seller Accounts Table
		
		$id = $this->db->insert_id();
		
		$data = array(	'user_id'							=> $id,
						'business_name'						=> $additional_data['business_name'],
						'title'								=> $additional_data['title'],
						'business_street_address'			=> $additional_data['business_street_address'],
						'business_city'						=> $additional_data['business_city'],
						'business_state'					=> $additional_data['business_state'],
						'business_zip_code'					=> $additional_data['business_zip_code'],
						'fax_number'						=> $additional_data['fax_number'],
						'telephone_number'					=> $additional_data['telephone_number']
						 );

		$this->db->insert($this->tables['sellers_accounts'], $data);

		return $this->db->affected_rows() > 0 ? $id : false;
	}

	/**
	 * login
	 *
	 * @return bool
	 * @author Mathew
	 **/
	
	// public function login($email, $password) {
//	 
		// if (empty($email) || empty($password)) {
			// return FALSE;
		// }
// 
		// $this->db->select('*');
		// $this->db->from('users');
		// $this->db->where('email', $email);
		// $this->db->where('password', $password);
		// $query = $this->db->get();
		// $result = $query->row();
// 
		// if ($query->num_rows() == 1) {
// 			
			// echo "Test Login Pass" ;
//			 
			// // TODO Set up encription
			// //$password = $this->hash_password_db($password);
			// //$password = $this->$password;
// 
			// if ($result->password === $password) {
				// $session_data = array(
					// 'user_id'	   => $result->user_id,
					// 'account_type'  => $result->account_type
				// );
				// $this->session->set_userdata($session_data);
				// return TRUE;
			// }
		// }
		// echo "Failed Login";
		// return FALSE;
	// }
	
	public function get_users($group=false, $limit=NULL, $offset=NULL)
	{
		$this->db->select(array(
				$this->tables['users'].'.*',
				$this->tables['groups'].'.name AS '. $this->db->protect_identifiers('group'),
				$this->tables['groups'].'.description AS '. $this->db->protect_identifiers('group_description')
				   ));

		if (!empty($this->columns))
		{
		foreach ($this->columns as $field)
		{
			$this->db->select($this->tables['meta'].'.'. $field);
		}
		}

		$this->db->join($this->tables['meta'], $this->tables['users'].'.id = '.$this->tables['meta'].'.'.$this->meta_join, 'left');
		$this->db->join($this->tables['groups'], $this->tables['users'].'.group_id = '.$this->tables['groups'].'.id', 'left');

		if (is_string($group))
		{
		$this->db->where($this->tables['groups'].'.name', $group);
		}
		else if (is_array($group))
		{
		$this->db->where_in($this->tables['groups'].'.name', $group);
		}

		
		if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}


		if (isset($limit) && isset($offset))
			$this->db->limit($limit, $offset);
		

		return $this->db->get($this->tables['users']);
	}

	/**
	 * get_users_count
	 *
	 * @return int Number of Users
	 * @author Sven Lueckenbach
	 **/
	public function get_users_count($group=false)
	{
		if (is_string($group))
		{
			$this->db->where($this->tables['groups'].'.name', $group);
		}
		else if (is_array($group))
		{
			$this->db->where_in($this->tables['groups'].'.name', $group);
		}

		if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}		

		$this->db->from($this->tables['users']);

		return $this->db->count_all_results();
	}

	/**
	 * get_active_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_active_users($group_name = false)
	{
		$this->db->where($this->tables['users'].'.active', 1);

		return $this->get_users($group_name);
	}

	/**
	 * get_inactive_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_inactive_users($group_name = false)
	{
		$this->db->where($this->tables['users'].'.active', 0);

		return $this->get_users($group_name);
	}

	/**
	 * get_user
	 *
	 * @return object
	 * @author Phil Sturgeon
	 **/
	public function get_user($id = false)
	{
		//if no id was passed use the current users id
		if (empty($id))
		{
		$id = $this->session->userdata('user_id');
		}

		$this->db->where($this->tables['users'].'.id', $id);
		$this->db->limit(1);

		return $this->get_users();
	}

	/**
	 * get_user_by_email
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_user_by_email($email)
	{
		$this->db->limit(1);

		return $this->get_users_by_email($email);
	}

	/**
	 * get_users_by_email
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_users_by_email($email)
	{
		$this->db->where($this->tables['users'].'.email', $email);

		return $this->get_users();
	}

	/**
	 * get_user_by_username
	 *
	 * @return object
	 * @author Kevin Smith
	 **/
	public function get_user_by_username($username)
	{
		$this->db->limit(1);

		return $this->get_users_by_username($username);
	}

	/**
	 * get_users_by_username
	 *
	 * @return object
	 * @author Kevin Smith
	 **/
	public function get_users_by_username($username)
	{
		$this->db->where($this->tables['users'].'.username', $username);

		return $this->get_users();
	}
	
	/**
	 * get_user_by_identity
	 *									  //copied from above ^
	 * @return object
	 * @author jondavidjohn
	 **/
	public function get_user_by_identity($identity)
	{
		$this->db->where($this->tables['users'].'.'.$this->identity_column, $identity);
		$this->db->limit(1);

		return $this->get_users();
	}

	/**
	 * get_newest_users
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_newest_users($limit = 10)
  	{
		$this->db->order_by($this->tables['users'].'.created_on', 'desc');
		$this->db->limit($limit);

		return $this->get_users();
  	}

	/**
	 * get_users_group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_users_group($id=false)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$user = $this->db->select('group_id')
				 ->where('id', $id)
				 ->get($this->tables['users'])
				 ->row();

		return $this->db->select('name, description')
				->where('id', $user->group_id)
				->get($this->tables['groups'])
				->row();
	}

	/**
	 * get_groups
	 *
	 * @return object
	 * @author Phil Sturgeon
	 **/
	public function get_groups()
  	{
		return $this->db->get($this->tables['groups'])
				->result();
  	}

	/**
	 * get_group
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_group($id)
  	{
		$this->db->where('id', $id);

		return $this->db->get($this->tables['groups'])
				->row();
  	}

	/**
	 * get_group_by_name
	 *
	 * @return object
	 * @author Ben Edmunds
	 **/
	public function get_group_by_name($name)
  	{
		$this->db->where('name', $name);

		return $this->db->get($this->tables['groups'])
				->row();
  	}

	/**
	 * update_user
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function update_user($id, $data)
	{
		$user = $this->get_user($id)->row();

		$this->db->trans_begin();

		if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
		{
			$this->db->trans_rollback();
			$this->ion_auth->set_error('account_creation_duplicate_'.$this->identity_column);
			return FALSE;
		}

		if (!empty($this->columns))
		{
			//filter the data passed by the columns in the config
			$meta_fields = array();
			foreach ($this->columns as $field)
			{
				if (is_array($data) && isset($data[$field]))
				{
				$meta_fields[$field] = $data[$field];
				unset($data[$field]);
				}
			}

			//update the meta data
			if (count($meta_fields) > 0)
			{
				// 'user_id' = $id
				$this->db->where($this->meta_join, $id);
				$this->db->set($meta_fields);
				$this->db->update($this->tables['meta']);
			}
		}

		if (array_key_exists('username', $data) || array_key_exists('password', $data) || array_key_exists('email', $data) || array_key_exists('group_id', $data))
			{
			if (array_key_exists('password', $data))
			{
				$data['password'] = $this->hash_password($data['password'], $user->salt);
			}

			$this->db->where($this->ion_auth->_extra_where);

			$this->db->update($this->tables['users'], $data, array('id' => $id));
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}

		$this->db->trans_commit();
		return TRUE;
	}


	/**
	 * delete_user
	 *
	 * @return bool
	 * @author Phil Sturgeon
	 **/
	public function delete_user($id)
	{
		$this->db->trans_begin();

		$this->db->delete($this->tables['meta'], array($this->meta_join => $id));
		$this->db->delete($this->tables['users'], array('id' => $id));

		if ($this->db->trans_status() === FALSE)
		{
		$this->db->trans_rollback();
		return FALSE;
		}

		$this->db->trans_commit();
		return TRUE;
	}


	/**
	 * update_last_login
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function update_last_login($id)
	{
		$this->load->helper('date');

		if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$this->db->update($this->tables['users'], array('last_login' => now()), array('id' => $id));

		return $this->db->affected_rows() == 1;
	}


	/**
	 * set_lang
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function set_lang($lang = 'en')
	{
		set_cookie(array(
			'name'   => 'lang_code',
			'value'  => $lang,
			'expire' => $this->config->item('user_expire', 'ion_auth') + time()
				));

		return TRUE;
	}

	/**
	 * login_remembed_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	public function login_remembered_user()
	{
		//check for valid data
		if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity')))
		{
			return FALSE;
		}

		//get the user
		if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
		{
			$this->db->where($this->ion_auth->_extra_where);
		}

		$query = $this->db->select($this->identity_column.', id, group_id')
				  ->where($this->identity_column, get_cookie('identity'))
				  ->where('remember_code', get_cookie('remember_code'))
				  ->limit(1)
				  ->get($this->tables['users']);

		//if the user was found, sign them in
		if ($query->num_rows() == 1)
		{
		$user = $query->row();
		
		$this->update_last_login($user->id);

		$group_row = $this->db->select('name')->where('id', $user->group_id)->get($this->tables['groups'])->row();

		$session_data = array(
					$this->identity_column => $user->{$this->identity_column},
					'id'				   => $user->id, //kept for backwards compatibility
					'user_id'			  => $user->id, //everyone likes to overwrite id so we'll use user_id
					'group_id'			 => $user->group_id,
					'group'				=> $group_row->name
					 );

		$this->session->set_userdata($session_data);


		//extend the users cookies if the option is enabled
		if ($this->config->item('user_extend_on_login', 'ion_auth'))
		{
			$this->remember_user($user->id);
		}

		return TRUE;
		}

		return FALSE;
	}

	/**
	 * remember_user
	 *
	 * @return bool
	 * @author Ben Edmunds
	 **/
	private function remember_user($id)
	{
		if (!$id)
		{
			return FALSE;
		}

		$user = $this->get_user($id)->row();

		$salt = sha1($user->password);

		$this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

		if ($this->db->affected_rows() > -1)
		{
			set_cookie(array(
					'name'   => 'identity',
					'value'  => $user->{$this->identity_column},
					'expire' => $this->config->item('user_expire', 'ion_auth'),
					));

			set_cookie(array(
					'name'   => 'remember_code',
					'value'  => $salt,
					'expire' => $this->config->item('user_expire', 'ion_auth'),
					));

			return TRUE;
		}

		return FALSE;
	}
}

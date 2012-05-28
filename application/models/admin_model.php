<?php 

class Admin_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function submit_bid($data) {
		$result = $this->db->insert('bids', $data);
		return $result; 
	}
	
	
//  function cron_test() {
//	  $this->db->where('id', '2');
//	  $result = $this->db->update('users', array('last_name' => 'Seller'));
//	  return $result;
//  }
/*
	function check_for_exisitng_vin($vin) {
		$this->db->select('*');
		$this->db->from('vehicles');
		$this->db->where('vin', $vin);
		$this->db->where('listing_status', 'active_listing');
		$query = $this->db->get();
		return $query->result();
	}

	function check_for_bids($vehicle_id, $buyer_id) {
		// TODO Check for bid session still.
		$this->db->select('*');
		$this->db->from('bids');
		$this->db->where('bids.vehicle_id', $vehicle_id);
		$this->db->where('bids.buyer_id', $buyer_id);
		$query = $this->db->get();
		return $query->result();
	}

	function delete_vehicle_image($image_id) {
		$result = $this->db->delete('vehicle_images', array('image_id' => $image_id)); 
		return $result;
	}
	
	function update_vehicle($vehicle_id, $data){
		$result = $this->db->update('vehicles', $data, "vehicle_id = $vehicle_id"); 
		return $result;   
	}
	
	function check_user_email($email_address){
		$this->db->select('*');
		$this->db->where('email', $email_address);
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function get_buyers_account_data ($user_id) {
		$this->db->select('*, buyers_accounts.user_id');
		$this->db->from('users');
		$this->db->where('users.id', $user_id);
		$this->db->join('buyers_accounts', 'buyers_accounts.user_id = users.id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_sellers_account_data ($user_id) {
		$this->db->select('*, sellers_accounts.user_id');
		$this->db->from('users');
		$this->db->where('users.id', $user_id);
		$this->db->join('sellers_accounts', 'sellers_accounts.user_id = users.id', 'left');
		$query = $this->db->get();
		return $query->result();
	}

	function approve_account($user_id) {
		$this->db->where('id', $user_id);
		$result = $this->db->update('users', array ('approved' => 'approved'));
		return $result;
	}

	function decline_account($user_id) {
		$this->db->where('id', $user_id);
		$result = $this->db->update('users', array ('approved' => 'declined'));
		return $result;
	}

	function get_user_details($email_address) {
		$this->db->select('*');
		$this->db->where('email', $email_address);
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	/* 
	 * TODO - I think the parameter here should be changed to $user_id since it should work for buyers and sellers
	 * 
	 */  
	
	// function get_user_details_by_id ($buyer_id) {
		// $this->db->select('*');
		// $this->db->where('id', $buyer_id);
		// $this->db->from('users');
		// $query = $this->db->get();
		// return $query->result();
	// }
//	 
	// function get_all_pending_buyer_accounts () {
		// $this->db->select('*, buyers_accounts.user_id');
		// $this->db->where('approved', 'pending');
		// $this->db->where('account_type', 'buyer');
		// $this->db->from('users');
		// $this->db->join('buyers_accounts', 'buyers_accounts.user_id = users.id', 'left');
		// $query = $this->db->get();
		// return $query->result();
	// }
	
//  function get_model_years(){
//
//	  $namespace="urn:configcompare3.kp.chrome.com";
//	  $wsdl = "http://platform.chrome.com/AutomotiveConfigCompareService/AutomotiveConfigCompareService3?WSDL";
//	  $client = new SoapClient($wsdl);
//
//	  $locale = array(
//			  "country" => "US",
//			  "language" => "EN"
//			  );
//				  
//			  $accountInfo = array(
//		  "accountNumber" => "283720",
//		  "accountSecret" => "a9346d13d32b422c",
//		  "locale" => $locale,
//		  "sessionId" => ""
//		  );
//
//		  $filterRules = array(
//		  "orderAvailability" => "Retail",
//		  "postalCode" => "97232",
//		  "vehicleTypes" => "Car",
//		  "msrpRange" => array(
//			  "minimumPrice" => "0",
//			  "maximumPrice" => "500000"
//			  )
//		  );
//
//		  $divisionsRequest = array(
//		  "accountInfo" => $accountInfo,
//		  "filterRules" => $filterRules
//		  );
//			  
//		  $modelYearRequest = array(
//		  "accountInfo" => $accountInfo,
//		  "filterRules" => $filterRules
//		  );
//
//		  $result = $client->getModelYears($modelYearRequest);
//		  $model_years = $result->i;
//		  return $model_years;
//  }

	function get_model_years(){
		
		$namespace="urn:description6.kp.chrome.com";

		$wsdl = "http://platform.chrome.com/AutomotiveDescriptionService/AutomotiveDescriptionService6?WSDL";
		$client = new SoapClient($wsdl);
		
		$locale = array(
				"country" => "US",
				"language" => "EN"
			);
		$accountInfo = array(
			"accountNumber" => "283720",
			"accountSecret" => "a9346d13d32b422c",
			"locale" => $locale,
			"sessionId" => ""
		);
		
		// Get data version -- for display in html title
			$version = "";
			$dataVersionsRequest = array(
				"accountInfo" => $accountInfo
			);
			
			$getDataVersions = array(
				"accountInfo" => $accountInfo,				  
				 );
				 
			$result = $client->getDataVersions($dataVersionsRequest);
			
		$ModelYearsRequest = array(
				"accountInfo" => $accountInfo,
							);
		
		$result = $client->getModelYears($ModelYearsRequest);
		$model_years = $result->i;
		return $model_years;
		
	}
	
	function get_vin_data($vin) {
		
		//PHP5 samples use native PHP5 SOAP.

		$namespace="urn:description6.kp.chrome.com";
		$wsdl = "http://platform.chrome.com/AutomotiveDescriptionService/AutomotiveDescriptionService6?WSDL";
		$client = new SoapClient($wsdl);
		
		$locale = array(
			"country" => "US",
			"language" => "EN"
		);
		
		$accountInfo = array(
			"accountNumber" => "283720",
			"accountSecret" => "a9346d13d32b422c",
			"locale" => $locale,
			"sessionId" => ""
		);

		// Get data version -- for display in html title
		
		$version = "";
		$dataVersionsRequest = array(
			"accountInfo" => $accountInfo
		);
	
		$getDataVersions = array(
			"accountInfo" => $accountInfo,
		);
		 
		$result = $client->getDataVersions($dataVersionsRequest);
 

		// Define elements for and make getVehicleInformationFromVin request

		$returnParameters = array(
			"useSafeStandards" => 'true',
			"excludeFleetOnlyStyles" => 'false',
			"includeAvailableEquipment" => 'true',
			"includeExtendedDescriptions" => 'true',
			"includeExtendedTechnicalSpecifications" => 'false',
			"includeRegionSpecificStyles" => 'true',
			"includeConsumerInformation" => 'false',
			"enableEnrichedVehicleEquipment" => 'false'
		);
		
		$vinRequest = array(
			"accountInfo" => $accountInfo,
			"vin" => $vin,
			"manufacturerModelCode" => '',
			"trimName" => '',
			"wheelBase" => '',
			"manufacturerOptionCodes" => '',
			"equipmentDescriptions" => '',
			"exteriorColorName" => '',
			"returnParameters" => $returnParameters
		);
		
		$vehicleInfo = $client->getVehicleInformationFromVin($vinRequest);
		return $vehicleInfo;
		
	}
	
	// Depricated - lets use buyer and seller 
	
	function get_all_dealers(){
		$query = $this->db->get_where('users', array('account_type' => 'buyer'));
		return $query->result();
	}
	
	function get_all_buyers(){
		$query = $this->db->get_where('users', array('account_type' => 'buyer'));
		return $query->result();
	}
	
	function get_all_buyer_accounts(){
		$this->db->select('*, buyers_accounts.user_id');
		$this->db->where('account_type', 'buyer');
		$this->db->from('users');
		$this->db->join('buyers_accounts', 'buyers_accounts.user_id = users.id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_all_seller_accounts(){
		$this->db->select('*, sellers_accounts.user_id');
		$this->db->where('account_type', 'seller');
		$this->db->from('users');
		$this->db->join('sellers_accounts', 'sellers_accounts.user_id = users.id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function add_vehicle($data) {
		
		//****************  Upload image 4096 = 4MB *****************/
		$config = array (
			'allowed_types'  => 'jpg|jpeg|gif|png',
			'upload_path'	=> './_uploads',
			'file_name'	  =>  $this->session->userdata('user_id')."_".now(), 
			'max_size'	   => '4096' 
		);
		
		$this->load->library('upload', $config);
		if ($this->upload->do_upload()) {
			$image_data = $this->upload->data();
			
			//****************  Resize and Rename *****************/
	
			//echo "FULL PATH DATA MODEL 23: ".$image_data['full_path'];
			
			$config = array(
				'create_thumb'  => TRUE,
				'source_image'  => $image_data['full_path'],
				'new_image'	 => './_thumbnails',
				'width'		 => 300,
				'height'		=> 100000,
				'maintain_ratio'=> TRUE,
				'thumb_marker'  => ''
			);
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			unlink($image_data['full_path']);
			// $config = array(
				// 'create_thumb'   => FALSE,
				// 'source_image'   => $image_data['full_path'],
				// 'width'		  => 600,
				// 'height'	 => 100000,
				// 'maintain_ratio'=> TRUE,
			// );
			// $this->image_lib->clear();
			// $this->image_lib->initialize($config); 
			// $this->image_lib->resize();
			
			$data['main_image_path'] = $image_data['file_name'];
		
			$result = $this->db->insert('vehicles', $data);
			
			if ($result) {
				$vehicle_id = $this->db->insert_id();
				$vehicle_image_data = array(
					'vehicle_id'	=>  $vehicle_id,
					'image_name'	=>  $image_data['file_name']
				);
				$this->db->insert('vehicle_images', $vehicle_image_data);
				return $vehicle_id;
				//redirect("site/vehicle_added/".$vehicle_id);
			} else {
				return FALSE;
				//echo "There was an error.";
			}
		} else {
			echo $this->upload->display_errors();
		}
	}
	
	function get_user_by_id($user_id) {
		$query = $this->db->get_where('users', array('id' => $user_id));
		return $query->result();
	}

	function check_approved($email) {
		$this->db->select('credit_card_validation');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		return $query->result();
	}
	
	function get_all_vehicles_for_sale_with_images() {
//	  $query = $this->db->get('vehicles');
//	  return $query->result();
		
		$this->db->select('*, vehicles.vehicle_id');
		$this->db->where('listing_status', 'active_listing');
		$this->db->where('bid_status', 'open');
		$this->db->from('vehicles');
		//$this->db->group_by("vehicles.vehicle_id");
		$this->db->join('vehicle_images', 'vehicles.vehicle_id = vehicle_images.vehicle_id', 'left');
		$this->db->order_by('vehicles.date_added', 'desc');
		$query = $this->db->get();
		return $query->result();
		
		//$this->db->select('*');
		//$this->db->from('vehicles');
		//$this->db->join('bids', 'vehicles.vehicle_id = bids.vehicle_id');
		//$this->db->group_by('bids.vehicle_id');
		//$query = $this->db->get();
		//return $query->result();
	}
	
	function get_all_vehicles_and_related_data() {
		$this->db->select('*, vehicles.vehicle_id');
		$this->db->from('vehicles');
		$this->db->join('users', 'vehicles.user_id = users.id', 'left');
		//$this->db->join('bids', 'vehicles.vehicle_id = bids.vehicle_id', 'left');
		$this->db->order_by('vehicles.date_added', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_vehicles_for_sale() {
		$this->db->select('*');
		$this->db->where('listing_status', 'active_listing');
		$this->db->from('vehicles');
		$this->db->order_by('vehicles.date_added', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_vehicle_images($vehicle_id) {
		$query = $this->db->get_where('vehicle_images', array('vehicle_id' => $vehicle_id));
		return $query->result();
	}
	
	function get_all_active_listings_by_user($user_id) {
		//$query = $this->db->get_where('vehicles', array('user_id' => $user_id));
		//return $query->result();
		$this->db->select('*, vehicles.vehicle_id');
		$this->db->where('user_id', $user_id);
		$this->db->where('listing_status', 'active_listing');
		$this->db->from('vehicles');
		$this->db->join('vehicle_images', 'vehicles.vehicle_id = vehicle_images.vehicle_id', 'left');
		$this->db->order_by('vehicles.date_added', 'desc');
		//$this->db->join('bids', 'vehicles.vehicle_id = bids.vehicle_id');
		//$this->db->group_by('bids.vehicle_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_all_inactive_vehicles_by_user($user_id) {
		$this->db->select('*, vehicles.vehicle_id');
		$this->db->where('user_id', $user_id);
		$this->db->where('listing_status', 'inactive_listing');
		$this->db->from('vehicles');
		$this->db->join('vehicle_images', 'vehicles.vehicle_id = vehicle_images.vehicle_id', 'left');
		$this->db->order_by('vehicles.date_added', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_vehicle_bid_history($vehicle_id, $bid_session = 0){
		if ($bid_session == 0) {
			$where_array = array(
			   'vehicle_id'	=> $vehicle_id,
			);
		} else {
			$where_array = array(
			   'vehicle_id'	=> $vehicle_id,
			   'bid_session'   => $bid_session
			);
		}
		
		$query = $this->db->get_where('bids', $where_array);
		return $query->result();
	}
	
	function get_vehicle_high_bid($vehicle_id, $bid_session){
		//$this->db->select_max('bid_amount');
		$this->db->order_by('bid_amount', 'desc');
		$this->db->order_by('bid_time', 'asc');
		$where_array = array(
			'vehicle_id'	=> $vehicle_id,
			'bid_session'   => $bid_session
		);
		$query = $this->db->get_where('bids', $where_array, 1);
		return $query;
	}
	
	function get_user_current_bid($vehicle_id, $buyer_id, $bid_session){
		//$this->db->select_max('bid_amount');
		//echo "vehicle_id: ".$vehicle_id;
		//echo "buyer_id: ".$buyer_id;
		$this->db->order_by('bid_amount', 'desc');
		//$this->db->order_by('bid_time', 'asc');
		$where_array = array(
			'vehicle_id'	=> $vehicle_id,
			'buyer_id'	  => $buyer_id,
			'bid_session'   => $bid_session
		);
		$query = $this->db->get_where('bids', $where_array, 1);
		return $query;
	}
	
	function get_accepted_bid_amount($vehicle_id, $buyer_id) {
		$this->db->select('*');
		$this->db->where('vehicle_id', $vehicle_id);
		$this->db->where('buyer_id', $buyer_id);
		$this->db->from('bids');
		$query = $this->db->get();
		return $query->result();
	}
	
	function submit_bid($data) {
		$result = $this->db->insert('bids', $data);
		if ($result) {
			return $result; 
		}
	}
	
	
	
	function accept_bid($vehicle_id, $buyer_id, $bid_id) {
		date_default_timezone_set('UTC');
		$this->db->where('vehicle_id', $vehicle_id);
		$result = $this->db->update(
			'vehicles', 
			 array(
				'listing_status'	=> 'accepted_bid', 
				 'bid_status'	   => 'accepted_bid', 
				 'winning_bid_id'   => $bid_id, 
				 'bid_accepted_date'	=> date('Y-m-d H:i:s', time()),
				 'buyer_id'		 => $buyer_id
			 )
		 );

		//$result = $this->db->update('vehicles', array('listing_status' => 'active_listing'));
		
		if(!$result) {
			echo "Sorry, there was an error. Please try again later.";
		} else {
			$this->db->select('*');
			$this->db->where('users.id', $buyer_id);
			$this->db->from('users');
			$this->db->join('buyers_accounts', 'users.id = buyers_accounts.user_id', 'left');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	
	function get_seller_details($seller_id) {
		$this->db->select('*');
		$this->db->where('users.id', $seller_id);
		$this->db->from('users');
		$this->db->join('sellers_accounts', 'users.id = sellers_accounts.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_vehicle_bid_details($vehicle_id) {
		$this->db->select('*');
		$this->db->where('vehicles.vehicle_id', $vehicle_id);
		$this->db->from('vehicles');
		$this->db->join('bids', 'bids.vehicle_id = vehicles.vehicle_id', 'left');
		$this->db->join('users', 'users.id = bids.buyer_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_bid_details($bid_id) {
		$this->db->select('*');
		$this->db->where('bid_id', $bid_id);
		$this->db->from('bids');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_buyer_details($buyer_id) {
		$this->db->select('*');
		$this->db->where('users.id', $buyer_id);
		$this->db->from('users');
		$this->db->join('buyers_accounts', 'users.id = buyers_accounts.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_vehicle_details($vehicle_id) {
		$this->db->select('*');
		$this->db->where('vehicle_id', $vehicle_id);
		$this->db->from('vehicles');
		$this->db->join('users', 'users.id = vehicles.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function register_creditcard_info($id,$payment_type,$card_number,$cvv,$card_expiration_month,$card_expiration_year) {
		$this->db->where('id', $id);
		
		echo $id;
		
			$result = $this->db->update(
			'buyers_accounts', 
				array(
						'payment_type'  => $payment_type, 
						'card_number'	   =>$card_number, 
						'cvv'   => $cvv, 
						'card_expiration_month' => $card_expiration_month,
						'card_expiration_year'		  => $card_expiration_year
					)
				);
	
	}
	function delete_vehicle($vehicle_id) {
		//$result = $this->db->delete('vehicles', array('vehicle_id' => $vehicle_id));
		//return $result;
		$data = array('listing_status' => 'deleted');
		$this->db->where('vehicle_id', $vehicle_id);
		$result = $this->db->update('vehicles', $data);
		return $result;
	}
	
	function get_vehicle_by_id($vehicle_id) {
		$query = $this->db->get_where('vehicles', array('vehicle_id' => $vehicle_id));
		return $query->result();
	}
	
	function deactivate_vehicle($vehicle_id) {
		$data = array('listing_status' => 'inactive_listing');
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->update('vehicles', $data);
		return $query;
	}
	
	function activate_vehicle($vehicle_id, $bid_session) {
		date_default_timezone_set('UTC');
		$data = array (
		  'listing_status' => 'active_listing', 
		  'date_added' => date('Y-m-d H:i:s', time()),
		  'bid_status' => 'open',
		  'bid_session' => $bid_session + 1
		);
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->update('vehicles', $data);
		return $query;
	}
	
	function register_stripe_failed($email) {
		//print $email;
		$this->db->where('email', $email);
		$query = $this->db->update('users', array('credit_card_validation' => 'declined'));
		return $query;
	}

	function expire_bid_status($vehicle_id){
		$data = array('bid_status' => 'expired');
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->update('vehicles', $data);
	}
	
	function get_accepted_bids_by_seller($seller_id){
		$this->db->select('*, bids.bid_id');
		$this->db->where('vehicles.user_id', $seller_id);
		$this->db->where('listing_status', 'accepted_bid');
		$this->db->from('vehicles');
		$this->db->join('bids', 'bids.bid_id = vehicles.winning_bid_id', 'left');
		$this->db->join('sellers_accounts', 'bids.seller_id = sellers_accounts.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_accepted_bids_by_buyer($buyer_id){
		$this->db->select('*, bids.bid_id');
		$this->db->where('vehicles.buyer_id', $buyer_id);
		$this->db->where('listing_status', 'accepted_bid');
		$this->db->from('vehicles');
		$this->db->join('bids', 'bids.bid_id = vehicles.winning_bid_id', 'left');
		$this->db->join('buyers_accounts', 'bids.buyer_id = buyers_accounts.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function register_stripe_id($stripe_id,$email) {
		$this->db->where('email',$email);
		$query = $this->db->update('users',array('stripe_id'=>$stripe_id, 'credit_card_validation'=>'approved'));
		return $query;
	}
	

	function get_transactions_to_invoice_by_buyer($buyer_id){
		$this->db->select('*, bids.bid_id');
		$this->db->where('vehicles.buyer_id', $buyer_id);
		$this->db->where('listing_status', 'accepted_bid');
		$this->db->where('invoice_status', 'not_invoiced');
		$this->db->from('vehicles');
		$this->db->join('bids', 'bids.bid_id = vehicles.winning_bid_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_buyers_to_invoice () {
		$this->db->select('*');
		$this->db->where('bid_status', 'accepted_bid');
		$this->db->where('invoice_status', 'not_invoiced');
		$this->db->from('vehicles');
		$this->db->join('users', 'users.id = vehicles.buyer_id', 'left');
		$this->db->join('bids', 'bids.bid_id = vehicles.winning_bid_id', 'left');
		$this->db->group_by("vehicles.buyer_id");
		//$this->db->order_by("users.id", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function mark_invoice_sent($vehicle_id) {
		$data = array('invoice_status' => 'invoiced');
		$this->db->where('vehicle_id', $vehicle_id);
		$query = $this->db->update('vehicles', $data);
	}
	
	function valid_credit_card ($buyer_id) {
		$this->db->select('*');
		$this->db->where('users.id', $buyer_id);
		$this->db->where('users.credit_card_validation', 'approved');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}

}
	
?>
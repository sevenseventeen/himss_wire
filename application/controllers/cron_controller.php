<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_Controller extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('content_model');
		$this->load->model('subscription_model');
	}
	
	public function index_archive() {
		
		$pending_articles = $this->content_model->get_pending_articles();
		foreach($pending_articles as $article) {
			$publish_date = $article->publish_date;
			$unix_publish_date = human_to_unix($publish_date);
			$now = time();
			if ($unix_publish_date <= $now) {
				echo "Set to pubished<br />";
			} else {
				echo "Don't Set to pubished<br />";
			}
		}
	}
	
	public function index() {
		$published_articles = $this->content_model->get_published_articles();
		// TODO This could be more efficient. Right now, we're looping though every article to get it's account id,
		// but ...
		// Maybe we should find get all subscriptions with expiration dates after today.
		// Then, find all articles with that subscription_id and expire them.   
		foreach($published_articles as $article) {
			$subscriber_account_id = $article->subscriber_id;
			$subscription = $this->subscription_model->get_subscription_by_account_id($subscriber_account_id);
			$expiration_date = $subscription[0]->subscription_end_date;
			echo $expiration_date;
			// $unix_publish_date = human_to_unix($publish_date);
			// $now = time();
			// if ($unix_publish_date <= $now) {
	// //			echo "Set to pubished<br />";
			// } else {
		// //		echo "Don't Set to pubished<br />";
			// }
		}
	}
	
	// Get all articles with status of published
	// Check to see if they are expired
	// Set status to expired.
}
 
?>



<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	
		<fieldset>
			<p>
				Company Name: 	<span class="data"><?php echo $subscriber_account[0]->company_name; ?></span><br />
				Website: 		<span class="data"><?php echo $subscriber_account[0]->website; ?></span><br />
				First Name:		<span class="data"><?php echo $subscriber_account[0]->first_name; ?></span><br />
				Last Name: 		<span class="data"><?php echo $subscriber_account[0]->last_name; ?></span><br />
				Phone Number: 	<span class="data"><?php echo $subscriber_account[0]->phone_number; ?></span><br />
				Street Address:	<span class="data"><?php echo $subscriber_account[0]->street_address; ?></span><br />
				City: 			<span class="data"><?php echo $subscriber_account[0]->city; ?></span><br />
				State: 			<span class="data"><?php echo $subscriber_account[0]->state; ?></span><br />
				Zip Code: 		<span class="data"><?php echo $subscriber_account[0]->zip_code; ?></span><br />
				Email:			<span class="data"><?php echo $user_account[0]->email; ?></span><br />
				Password: 		<span class="data"><?php echo $user_account[0]->password; ?></span><br />
			</p>
			<?php 
				$user_id = $user_account[0]->user_id;
				$subscriber_account_id = $subscriber_account[0]->subscriber_account_id;
			?>
			<!--<p><a href='<?php echo base_url()."admin/edit_subscriber_account/$user_id/$subscriber_account_id" ?>'>Edit This Accoount</a></p>-->
			<h2>Subscription Package</h2>
			<?php if ($subscription_details) { ?>
				<p>
					Package Summary: 	<span class="data"><?php echo $subscription_details[0]->subscription_summary; ?></span><br />
					Package Details: 	<span class="data"><?php echo $subscription_details[0]->subscription_details; ?></span><br />
					Number of Stories:	<span class="data"><?php echo $subscription_details[0]->stories_purchased; ?></span><br />
					Subscription Start: <span class="data"><?php echo $subscription_details[0]->subscription_start_date; ?></span><br />
					Subscription End: 	<span class="data"><?php echo $subscription_details[0]->subscription_end_date; ?></span><br />
				</p>
				<!--<p>
					<a href="#">Edit This Subscription</a>
				</p>-->
			<?php } else { ?>
				<h3>No subscription package found.</h3>
			<?php } ?>
		</fieldset>
		
		<h3>Past Reports</h3>
		<?php foreach ($reports as $report) { ?>
			<a href="<?php echo base_url().'_reports/'.$report->report_path ?>"><?php echo $report->report_title; ?></a><br /> 
		<? } ?>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
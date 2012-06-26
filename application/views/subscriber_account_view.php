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
			<h2>Subscription Package</h2>
			<?php if ($subscription_details) { ?>
				<?php 
					$subscription_start_date_datetime = new DateTime($subscription_details[0]->subscription_start_date); 
					$subscription_start_date_formattted = $subscription_start_date_datetime->format('Y-m-d');
					$subscription_end_date_datetime = new DateTime($subscription_details[0]->subscription_end_date); 
					$subscription_end_date_formattted = $subscription_end_date_datetime->format('Y-m-d');
				?>
				<p>
					Articles Published:	<span class="data"><?php echo count($articles); ?></span><br />
					Package Summary: 	<span class="data"><?php echo $subscription_details[0]->subscription_summary; ?></span><br />
					Package Details: 	<span class="data"><?php echo $subscription_details[0]->subscription_details; ?></span><br />
					Number of Stories:	<span class="data"><?php echo $subscription_details[0]->stories_purchased; ?></span><br />
					Subscription Start: <span class="data"><?php echo $subscription_start_date_formattted; ?></span><br />
					Subscription End: 	<span class="data"><?php echo $subscription_end_date_formattted; ?></span><br />
				</p>
			<?php } else { ?>
				<h3>No subscription package found.</h3>
			<?php } ?>
		</fieldset>
		
		<h3>Past Reports</h3>
		<?php foreach ($reports as $report) { ?>
			<a href="<?php echo base_url().'_reports/'.$report->report_path ?>"><?php echo $report->report_title; ?></a><br /> 
		<? } ?>
		
		<h2>Story Request</h2>
		<?php echo form_open_multipart('subscribers/request_story'); ?>
			<fieldset>
				<label>First Name</label>
					<?php echo form_input('first_name', set_value('first_name', $subscriber_account[0]->first_name)); ?>
					<?php echo form_error('first_name'); ?>
					<br class="clear_float" />
				<label>Last Name</label>
					<?php echo form_input('last_name', set_value('last_name', $subscriber_account[0]->last_name)); ?>
					<?php echo form_error('last_name'); ?>
					<br class="clear_float" />
				<label>Company Name</label> 
					<?php echo form_input('company_name', set_value('company_name', $subscriber_account[0]->company_name)); ?>
					<?php echo form_error('company_name'); ?>
					<br class="clear_float" />
				<label>Website</label>
					<?php echo form_input('website', set_value('website', $subscriber_account[0]->url)); ?>
					<?php echo form_error('website'); ?>
					<br class="clear_float" />
				<label>Email</label>
					<?php echo form_input('email', set_value('email', $user_account[0]->email)); ?>
					<?php echo form_error('email'); ?>
					<br class="clear_float" />
				<label>Phone Number</label>
					<?php echo form_input('phone_number', set_value('phone_number', $subscriber_account[0]->phone_number)); ?>
					<?php echo form_error('phone_number'); ?>
					<br class="clear_float" />
				<label>Request Specifics</label>
					<?php echo form_textarea('request_specifics', set_value('request_specifics', '')); ?>
					<?php echo form_error('request_specifics'); ?>
					<br class="clear_float" />
				<label>Supporting Documents</label>
					<?php echo form_upload('userfile', set_value('userfile')); ?>
					<?php echo form_error('userfile'); ?>
					<br class="clear_float" />
				<?php echo form_hidden('user_id', $user_account[0]->user_id); ?>
			</fieldset>
			<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
			
		<?php echo form_close(); ?>
		
		<p><a href='<?php echo base_url()."edit_subscriber_account/".$user_id ?>'>Edit This Account</a></p>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
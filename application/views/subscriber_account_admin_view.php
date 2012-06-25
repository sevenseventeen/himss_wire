<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
		<fieldset>
			<h2><?php echo $subscriber_account[0]->company_name; ?></h2>
			<p>
				Company Name: 	<span class="data"><?php echo $subscriber_account[0]->company_name; ?></span><br />
				Website: 		<span class="data"><?php echo $subscriber_account[0]->url; ?></span><br />
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
			
			
			<?php if ($subscription_details) { ?>
				<h2>Subscription Package</h2>
				<?php 
					$today_unix = unix_timestamp_to_unix_timestamp_without_time(now());
					$end_date_unix = human_to_unix($subscription_details[0]->subscription_end_date);
					if(timespan($today_unix, $end_date_unix) == "1 Second") {
						$days_remaining = 'Subscription Expired';
					} else {
						$days_remaining = timespan($today_unix, $end_date_unix);;
					}
				?>
				
				<?php 
					$start_datetime = new DateTime($subscription_details[0]->subscription_start_date);
					$end_datetime = new DateTime($subscription_details[0]->subscription_end_date);
					$start_date = $start_datetime->format('Y-m-d'); 
					$end_date = $end_datetime->format('Y-m-d'); 
				?>	
				<p>
					Remaining Subscription:	<span class="data"><?php echo $days_remaining; ?></span><br />
					Articles Published:		<span class="data"><?php echo count($articles); ?></span><br />
					Package Summary: 		<span class="data"><?php echo $subscription_details[0]->subscription_summary; ?></span><br />
					Package Details: 		<span class="data"><?php echo $subscription_details[0]->subscription_details; ?></span><br />
					Number of Stories:		<span class="data"><?php echo $subscription_details[0]->stories_purchased; ?></span><br />
					Subscription Start: 	<span class="data"><?php echo $start_date; ?></span><br />
					Subscription End: 		<span class="data"><?php echo $end_date ?></span><br />
				</p>
			<?php } else { ?>
				
				<!-- If no subscription package found, add a subscription. -->
				
				<?php echo form_open('admin/add_subscription_package'); ?>
					<fieldset>
						<h2>Add Subscription Package</h2>
						<label>Subscription Summary</label>
							<?php echo form_textarea('subscription_summary', set_value('subscription_summary', '')); ?>
							<?php echo form_error('subscription_summary'); ?>
							<br class="clear_float" />
						<label>Subscription Details</label>
							<?php echo form_textarea('subscription_details', set_value('subscription_details', '')); ?>
							<?php echo form_error('subscription_details'); ?>
							<br class="clear_float" />
						<label>Stories Purchased</label>
							<?php echo form_input('stories_purchased', set_value('stories_purchased', '')); ?>
							<?php echo form_error('stories_purchased'); ?>
							<br class="clear_float" />
						<label>Subscription Start</label>
							<input type="text" name="subscription_start" class="datepicker" />
							<?php echo form_error('subscription_start'); ?>
							<br class="clear_float" />
						<label>Subscription End</label>
							<input type="text" name="subscription_end" class="datepicker" />
							<?php echo form_error('subscription_end'); ?>
							<br class="clear_float" />
					</fieldset>
					<?php echo form_hidden('subscriber_account_id', $subscriber_account[0]->subscriber_account_id); ?>
					<?php echo form_hidden('user_id', $subscriber_account[0]->user_id); ?>
					<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
				<?php echo form_close(); ?>
			<?php } ?>
			
			<h2>Past Reports</h2>
			<p>
			<?php foreach ($reports as $report) { ?>
				<a href="<?php echo base_url().'_reports/'.$report->report_path ?>"><?php echo $report->report_title; ?></a><br /> 
			<? } ?>
			</p>
			
			<h2>Upload Report</h2>
			<?php echo form_open_multipart('admin/add_report');?>
				<fieldset>
					<label>Report Title</label>
						<?php echo form_input('report_title', set_value('report_title', '')); ?>
						<?php echo form_error('report_title'); ?>
						<br class="clear_float" />
					<label>Report PDF</label>
							<?php echo form_upload('userfile', set_value('userfile')); ?>
							<?php echo form_error('userfile'); ?>
							<br class="clear_float" />
					<?php echo form_hidden('subscriber_account_id', $subscriber_account[0]->subscriber_account_id); ?>
				</fieldset>
				<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
			<?php echo form_close(); ?>
			
			<p><a href='<?php echo base_url()."admin/edit_subscriber_account/$user_id/$subscriber_account_id" ?>'>Edit This Account</a></p>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
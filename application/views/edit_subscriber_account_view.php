<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	
	<h2>Update Subscriber Account --------------------------------------</h2>
	<pre>
	<?php //print_r($subscriber_account); ?>
	<hr />
	<?php //print_r($user_account); ?>
	</pre>
	<?php echo form_open('admin/update_subscriber_account'); ?>
	
		<fieldset>
			<legend>Update Subscriber Account</legend>
			
			<label>Company Name</label> 
				<?php echo form_input('company_name', set_value('company_name', $subscriber_account[0]->company_name)); ?>
				<?php echo form_error('company_name'); ?>
				<br class="clear_float" />
			
			<label>Website</label>
				<?php echo form_input('website', set_value('website', $subscriber_account[0]->website)); ?>
				<?php echo form_error('website'); ?>
				<br class="clear_float" />
			
			<label>First Name</label>
				<?php echo form_input('first_name', set_value('first_name', $subscriber_account[0]->first_name)); ?>
				<?php echo form_error('first_name'); ?>
				<br class="clear_float" />
			
			<label>Last Name</label>
				<?php echo form_input('last_name', set_value('last_name', $subscriber_account[0]->last_name)); ?>
				<?php echo form_error('last_name'); ?>
				<br class="clear_float" />
			
			<label>Phone Number</label>
				<?php echo form_input('phone_number', set_value('phone_number', $subscriber_account[0]->phone_number)); ?>
				<?php echo form_error('phone_number'); ?>
				<br class="clear_float" />
			
			<label>Street Address</label>
				<?php echo form_input('street_address', set_value('street_address', $subscriber_account[0]->street_address)); ?>
				<?php echo form_error('street_address'); ?>
				<br class="clear_float" />
			
			<label>City</label>
				<?php echo form_input('city', set_value('city', $subscriber_account[0]->city)); ?>
				<?php echo form_error('city'); ?>
				<br class="clear_float" />
			
			<label>State</label>
				<?php echo form_input('state', set_value('state', $subscriber_account[0]->state)); ?>
				<?php echo form_error('state'); ?>
				<br class="clear_float" />
			
			<label>Zip Code</label>
				<?php echo form_input('zip_code', set_value('zip_code', $subscriber_account[0]->zip_code)); ?>
				<?php echo form_error('zip_code'); ?>
				<br class="clear_float" />

			<label>Email</label>
				<?php echo form_input('email', set_value('email', $user_account[0]->email)); ?>
				<?php echo form_error('email'); ?>
				<br class="clear_float" />
			
			<label>Password</label>
				<?php echo form_input('password', set_value('password', $user_account[0]->password)); ?>
				<?php echo form_error('password'); ?>
				<br class="clear_float" />
				
		</fieldset>
		
		<?php echo form_hidden('subscriber_account_id', $subscriber_account[0]->subscriber_account_id); ?>
		<?php echo form_hidden('user_id', $subscriber_account[0]->user_id); ?>
		
		<input type="submit" />		
	
	<?php echo form_close(); ?>
	
	<!-- 
		
	----------- Add Subscription Package ------------- 
		
	-->
	
	<hr />
	<?php print_r($subscription_details); ?>
	<?php echo form_open('admin/update_subscription'); ?>
	
		<fieldset>
			<legend>Update Subscription Package</legend>
			
			<label>Package Summary</label>
				<?php echo form_input('subscription_summary', set_value('subscription_summary', $subscription_details[0]->subscription_summary)); ?>
				<?php echo form_error('subscription_summary'); ?>
				<br class="clear_float" />
			
			<label>Package Details</label>
				<?php echo form_input('subscription_details', set_value('subscription_details', $subscription_details[0]->subscription_details)); ?>
				<?php echo form_error('subscription_details'); ?>
				<br class="clear_float" />
			
			<label>Stories Purchased</label>
				<?php echo form_input('stories_purchased', set_value('stories_purchased', $subscription_details[0]->stories_purchased)); ?>
				<?php echo form_error('stories_purchased'); ?>
				<br class="clear_float" />
				
			<script>
				$(function() {
					$('#subscription_start').datepicker({
						onSelect: function(dateText, inst) {
							$('#subscription_start').val(dateText);
						}
					});
					$('#subscription_end').datepicker({
						onSelect: function(dateText, inst) {
							$('#subscription_end').val(dateText);
						}
					});
				});
			</script>
			
			<label>Subscription Start</label>
				<?php echo form_input('subscription_start', set_value('subscription_start', $subscription_details[0]->subscription_start_date), 'id="subscription_start"'); ?>
				<?php echo form_error('subscription_start'); ?>
				<br class="clear_float" />
			
			<label>Subscription End</label>
				<?php echo form_input('subscription_end', set_value('subscription_end', $subscription_details[0]->subscription_end_date), 'id="subscription_end"'); ?>
				<?php echo form_error('subscription_end'); ?>
				<br class="clear_float" />
				
		</fieldset>
		
		<?php echo form_hidden('subscription_id', $subscription_details[0]->subscription_id); ?>
		<?php echo form_hidden('user_id', $subscriber_account[0]->user_id); ?>
		
		<input type="submit" />		
	
	<?php echo form_close(); ?>
	
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
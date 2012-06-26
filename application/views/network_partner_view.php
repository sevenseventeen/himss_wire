<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<p>General Intro Content</p>
	<h1><?php echo $network_partner[0]->company_name; ?></h1>
	<h2>Widget Embed Code</h2>
	<p>
	<?php 
		foreach($feed_modules as $feed_module) {
			echo "<a href='".base_url()."feed_module/".$feed_module->feed_module_id."'>$feed_module->feed_module_name</a><br />";
		} 
	?>
	</p>
	<h2>FAQ's</h2>
	<?php 
		foreach ($faqs as $faq) {
			echo "<p class='question'>$faq->faq_question</p>";
			echo "<p class='answer'>$faq->faq_answer</p>";
			echo "<hr />";
		}
	?>
	<h2>Support &amp; Custom Widget Request</h2>
	<?php echo form_open('partners/request_support'); ?>
		<fieldset>
			<label>First Name</label>
				<?php echo form_input('first_name', set_value('first_name', $network_partner[0]->first_name)); ?>
				<?php echo form_error('first_name'); ?>
				<br class="clear_float" />
			<label>Last Name</label>
				<?php echo form_input('last_name', set_value('last_name', $network_partner[0]->last_name)); ?>
				<?php echo form_error('last_name'); ?>
				<br class="clear_float" />
			<label>Company Name</label> 
				<?php echo form_input('company_name', set_value('company_name', $network_partner[0]->company_name)); ?>
				<?php echo form_error('company_name'); ?>
				<br class="clear_float" />
			<label>Website</label>
				<?php echo form_input('website', set_value('website', $network_partner[0]->url)); ?>
				<?php echo form_error('website'); ?>
				<br class="clear_float" />
			<label>Email</label>
				<?php echo form_input('email', set_value('email', $user[0]->email)); ?>
				<?php echo form_error('email'); ?>
				<br class="clear_float" />
			<label>Phone Number</label>
				<?php echo form_input('phone_number', set_value('phone_number', $network_partner[0]->phone_number)); ?>
				<?php echo form_error('phone_number'); ?>
				<br class="clear_float" />
			<label>Request Specifics</label>
				<?php echo form_textarea('request_specifics', set_value('request_specifics', '')); ?>
				<?php echo form_error('request_specifics'); ?>
				<br class="clear_float" />
		</fieldset>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
	<?php echo form_close(); ?>
	<p><a href='<?php echo base_url()."edit_network_partner_account/".$user[0]->user_id ?>'>Edit This Account</a></p>
</div>
<br class="clear_float" />	

<?php 
	$this->content_library->load_footer();
?>
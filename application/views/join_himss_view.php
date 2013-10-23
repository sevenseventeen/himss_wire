<?php 
	$data['main_navigation'] = 'join';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2 static_page get_published">
	<?php echo $static_page_content[0]->content; ?>
	<!--<h2>Contact Us</h2>-->
	<?php 
		$name_data = array(
			'name' => 'name',
			'title' => 'Your Name',
			'value' => set_value('name'),
			'class' => 'inner_shadow'
		);
		$company_data = array(
			'name' => 'company',
			'title' => 'Your Company',
			'value' => 	set_value('company'),
			'class' => 'inner_shadow'
		);
		$email_data = array(
			'name' => 'email',
			'title' => 'Your Email',
			'value' => 	set_value('email'),
			'class' => 'inner_shadow'
		);
		$phone_data = array(
			'name' => 'phone',
			'title' => 'Your Phone Number',
			'value' => 	set_value('phone'),
			'class' => 'inner_shadow'
		);
		$message_data = array(
			'name' => 'message',
			'title' => 'Please type your message here.',
			'value' => set_value('message', 'Please type your message here.'),
			'class' => 'inner_shadow'
		);
		$submit_data = Array(
			'type' => 'submit', 
			'name' => 'submit', 
			'type' => 'submit', 
			'value' => 'Submit', 
			'alt' => 'Submit', 
			'class' => 'form_submit'
		);
	?>
	<?php //echo form_open('send_email/3'); ?>
	<?php //echo form_input($name_data); ?>		<?php echo form_error('name'); ?><br class="clear_float" />
	<?php //echo form_input($company_data); ?>	<?php echo form_error('company'); ?><br class="clear_float" />
	<?php //echo form_input($email_data); ?> 		<?php echo form_error('email'); ?> <br class="clear_float" />
	<?php //echo form_input($phone_data); ?>		<?php echo form_error('phone'); ?><br class="clear_float" />
	<?php //echo form_textarea($message_data); ?>	<?php echo form_error('message'); ?><br class="clear_float" />
	<?php //echo form_submit($submit_data);?>
	<?php //echo form_close(); ?>
</div>

<aside>
	<?php $this->load->view('_includes/feature_module'); ?>
	<?php $this->load->view('_includes/linked_in_module'); ?>
	<?php $this->load->view('_includes/banner_ad_module'); ?>
	<?php $this->load->view('_includes/partner_links_module'); ?>
</aside>

<br class="clear_float" />
	
<?php 
	$this->content_library->load_footer();
?>
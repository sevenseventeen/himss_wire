<?php 
	$data['main_navigation'] = 'about';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h1><?php echo $this->session->flashdata('message'); ?></h1>
	<h2>Please enter your email to have your password sent to you.</h2>
	<?php echo form_open('send_password'); ?>
		<fieldset>
			<label>Email</label>
				<?php echo form_input('email', set_value('email', '')); ?>
				<?php echo form_error('email'); ?>
				<br class="clear_float" />
		</fieldset>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
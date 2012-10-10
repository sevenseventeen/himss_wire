<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h2 class="error"><?php echo $this->session->flashdata('message'); ?></h2>
	<?php echo form_open('authentication/login_user'); ?>
		<fieldset>
			<h2>Login</h2>
			<label>Email</label> 
				<?php echo form_input('email', set_value('email', '')); ?>
				<?php echo form_error('email'); ?>
				<br class="clear_float" />
			<label>Password</label>
				<?php echo form_password('password', set_value('password', '')); ?>
				<a href="<?php echo base_url(); ?>forgot_password">Forgot Password</a>
				<?php echo form_error('password'); ?>
				<br class="clear_float" />
		</fieldset>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
	<?php echo form_close(); ?>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
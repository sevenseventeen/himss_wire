<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	
	<h2>Edit Editor Account --------------------------------------</h2>
<!-- 	<pre> -->
	<?php //print_r($admin_account); ?>
	<?php //print_r($user_account); ?>
	<!-- </pre> -->
	<?php echo form_open('admin/update_editor_account'); ?>
	
		<fieldset>
			<legend>Update External Account</legend>
			
			<label>First Name</label>
				<?php echo form_input('first_name', set_value('first_name', $editor_account[0]->first_name)); ?>
				<?php echo form_error('first_name'); ?>
				<br class="clear_float" />
			
			<label>Last Name</label>
				<?php echo form_input('last_name', set_value('last_name', $editor_account[0]->last_name)); ?>
				<?php echo form_error('last_name'); ?>
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
		
		<?php echo form_hidden('editor_account_id', $editor_account[0]->editor_account_id); ?>
		<?php echo form_hidden('user_id', $editor_account[0]->user_id); ?>
		
		<input type="submit" />		
	
	<?php echo form_close(); ?>
	
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
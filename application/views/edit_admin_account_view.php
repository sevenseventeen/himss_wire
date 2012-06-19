<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_admin_account'); ?>
		<fieldset>
			<h2>Update External Account</h2>
			<label>First Name</label>
				<?php echo form_input('first_name', set_value('first_name', $admin_account[0]->first_name)); ?>
				<?php echo form_error('first_name'); ?>
				<br class="clear_float" />
			<label>Last Name</label>
				<?php echo form_input('last_name', set_value('last_name', $admin_account[0]->last_name)); ?>
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
		<?php echo form_hidden('admin_account_id', $admin_account[0]->administrator_account_id); ?>
		<?php echo form_hidden('user_id', $admin_account[0]->user_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_account/<?php echo $user_account[0]->user_id; ?>">Delete Account</a>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
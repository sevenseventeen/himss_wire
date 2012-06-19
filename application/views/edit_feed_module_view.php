<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_feed_module');?>
		<fieldset>
			<h2>Edit Feed Module</h2>
			<label>Feed Module Name</label>
				<?php echo form_input('feed_module_name', set_value('feed_module_name', $feed_module[0]->feed_module_name)); ?>
				<?php echo form_error('feed_module_name'); ?>
				<br class="clear_float" />
			<label>Feed Module Code</label>
				<?php echo form_textarea('feed_module_code', set_value('feed_module_code', $feed_module[0]->feed_module_code)); ?>
				<?php echo form_error('feed_module_code'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('feed_module_id', $feed_module[0]->feed_module_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_feed_module/<?php echo $feed_module[0]->feed_module_id; ?>">Delete Feed Module</a>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
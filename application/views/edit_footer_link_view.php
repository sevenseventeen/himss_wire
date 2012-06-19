<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_footer_link');?>
		<fieldset>
			<h2>Edit Footer Links</h2>
			<label>Footer Link Text</label>
				<?php echo form_input('footer_link_text', set_value('footer_link_text', $footer_link[0]->footer_link_text)); ?>
				<?php echo form_error('footer_link_text'); ?>
				<br class="clear_float" />
			<label>Footer Link Text</label>
				<?php echo form_input('footer_link_url', set_value('footer_link_url', $footer_link[0]->footer_link_url)); ?>
				<?php echo form_error('footer_link_url'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('footer_link_id', $footer_link[0]->footer_link_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_footer_link/<?php echo $footer_link[0]->footer_link_id; ?>">Delete Footer Link</a>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
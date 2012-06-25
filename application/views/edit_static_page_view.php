<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h2>Edit Static Page</h2>
	<?php echo form_open('admin/update_static_page'); ?>
		<fieldset>
			<label>Page Name</label> 
				<?php echo form_input('page_name', set_value('page_name', $static_page[0]->page_name)); ?>
				<?php echo form_error('page_name'); ?>
				<br class="clear_float" />
			<label>Page Content</label> 
				<?php echo form_textarea('page_content', set_value('page_content', $static_page_content[0]->content), 'class="ckeditor"'); ?>
				<?php echo form_error('page_content'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('static_page_id', $static_page[0]->page_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
	<?php echo form_close(); ?>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
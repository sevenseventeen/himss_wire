<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	
	<h2>Edit category</h2>
	
	<?php echo form_open('admin/update_static_page'); ?>
	
		<fieldset>
			<?php print_r($static_page_content); ?>
			<legend>Edit Static Page</legend>
			
			<label>Page Name</label> 
				<?php echo form_input('page_name', set_value('page_name', $static_page[0]->page_name)); ?>
				<?php echo form_error('page_name'); ?>
				<br class="clear_float" />
			
			<label>Page Content</label> 
				<?php echo form_input('page_content', set_value('page_content', $static_page_content[0]->content)); ?>
				<?php echo form_error('page_content'); ?>
				<br class="clear_float" />
			
		</fieldset>
		
		<?php echo form_hidden('page_id', $static_page[0]->page_id); ?>
		
		<input type="submit" />	
			
	<?php echo form_close(); ?>
	
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
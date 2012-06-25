<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_category'); ?>
		<fieldset>
			<h2>Edit Category</h2>
			<label>Category Name</label> 
				<?php echo form_input('category_name', set_value('category_name', $category[0]->category_name)); ?>
				<?php echo form_error('category_name'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('article_category_id', $category[0]->article_category_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
	<?php echo form_close(); ?>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
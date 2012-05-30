<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h2>Edit Article</h2>
	<?php echo form_open('admin/update_article'); ?>
		<fieldset>
			<select name="article_category_id">
				<option value=''>Select a Category</option>
				<?php
					// TODO Need to set_value for select box 
					foreach ($categories as $category) { 
						echo "<option value='".$category->article_category_id."'>".$category->category_name."</option>";
					}
				?>
			</select>
			<br class="clear_float" />
			<label>Article Title</label> 
				<?php echo form_input('article_title', set_value('article_title', $article[0]->article_title)); ?>
				<?php echo form_error('article_title'); ?>
				<br class="clear_float" />
			<label>Published Status</label>
				<?php echo form_input('article_status', set_value('article_status', $article[0]->article_status)); ?>
				<?php echo form_error('article_status'); ?>
				<br class="clear_float" />
			<label>Article Tags</label>
				<?php echo form_input('article_tags', set_value('article_tags', $article[0]->article_tags)); ?>
				<?php echo form_error('article_tags'); ?>
				<br class="clear_float" />
			<label>Article Summary</label>
				<?php echo form_textarea('article_summary', set_value('article_summary', $article[0]->article_summary), 'class="ckeditor"'); ?>
				<?php echo form_error('article_summary'); ?>
				<br class="clear_float" />
			<label>Article Body</label>
				<?php echo form_textarea('article_body', set_value('article_body', $article[0]->article_body), 'class="ckeditor"'); ?>
				<?php echo form_error('article_body'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('article_id', $article[0]->article_id); ?>
		<input type="submit" />	
	<?php echo form_close(); ?>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
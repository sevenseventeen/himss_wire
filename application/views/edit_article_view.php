<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h1><?php echo $this->session->flashdata('message'); ?></h1>
	<h2>Edit Article</h2>
	<?php echo form_open('admin/update_article'); ?>
		<fieldset>
			<label>Subscriber</label>
			<select name="subscriber_id">
				<option value=''>Select a Subscriber</option>
				<?php 
					foreach ($subscribers_with_remaining_articles as $subscriber) {
						if($subscriber->subscriber_id == $article[0]->article_subscriber_id) {
						    $set_select = 'selected=selected';    
						} else {
						    $set_select = '';
						}
						echo "<option ".$set_select." value='".$subscriber->subscriber_account_id."' ".set_select('subscriber_id', $subscriber->subscriber_account_id).">".$subscriber->company_name."</option>";
					}
				?>
			</select>
			<?php echo form_error('subscriber_id'); ?>
			<label>Category</label>
			<select name="article_category_id">
				<option value=''>Select a Category</option>
				<?php
					foreach ($categories as $category) {
						if($category->article_category_id == $article[0]->article_category_id) {
						    $set_select = 'selected=selected';    
						} else {
						    $set_select = '';
						}
						echo "<option ".$set_select." value='".$category->article_category_id."' ".set_select('article_category_id', $category->article_category_id).">".$category->category_name."</option>"; 
					}
				?>
			</select>
			<?php echo form_error('article_category_id'); ?>
			<br class="clear_float" />
			<label>Article Title</label> 
				<?php echo form_input('article_title', set_value('article_title', $article[0]->article_title)); ?>
				<?php echo form_error('article_title'); ?>
				<br class="clear_float" />
			<label>Article Tags</label>
				<?php echo form_input('article_tags', set_value('article_tags', $article[0]->article_tags)); ?>
				<?php echo form_error('article_tags'); ?>
				<br class="clear_float" />
			<label>Article Summary</label>
				<?php echo form_textarea('article_summary', set_value('article_summary', $article[0]->article_summary), 'maxlength="160"'); ?>
				<?php echo form_error('article_summary'); ?>
				<br class="clear_float" />
			<label>Article Body</label>
				<?php echo form_textarea('article_body', set_value('article_body', $article[0]->article_body), 'class="ckeditor"'); ?>
				<?php echo form_error('article_body'); ?>
				<br class="clear_float" />
			<label>Draft</label>
				<?php 
					if ($article[0]->article_status == "Draft") {
						$checked = "checked='checked'";
					} else {
						$checked = "";
					} 
				?>
				<input <?php echo $checked; ?> type="checkbox" id="draft_status" name="draft_status" value="true" <?php echo set_checkbox('draft_status', 'true'); ?> />
				<?php echo form_error('draft_status'); ?>
				<br class="clear_float" />
			<div id="publish_date_container">
				<label>Publish Date</label>
					<?php 
						$publish_datetime = new DateTime($article[0]->publish_date);
						$publish_date = $publish_datetime->format('Y-m-d');
					?> 
					<input type="text" name="publish_date" id="publish_date" class="datepicker" value="<?php echo $publish_date; ?>"/>
					<?php echo form_error('publish_date'); ?>
					<br class="clear_float" />
			</div>
		</fieldset>
		<?php echo form_hidden('article_id', $article[0]->article_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
	<br /> <!-- TODO Remove this -->
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_article/<?php echo $article[0]->article_id; ?>">Delete Article</a>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
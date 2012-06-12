<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_faq');?>
		<fieldset>
			<legend>Edit FAQ</legend>
				<label>FAQ Question</label>
					<?php echo form_input('faq_question', set_value('faq_question', $faq[0]->faq_question)); ?>
					<?php echo form_error('faq_question'); ?>
					<br class="clear_float" />
				<label>FAQ Answer</label>
					<?php echo form_input('faq_answer', set_value('faq_answer', $faq[0]->faq_answer)); ?>
					<?php echo form_error('faq_answer'); ?>
					<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('faq_id', $faq[0]->faq_id); ?>
		<input type="submit" />
	<?php echo form_close(); ?>
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_faq/<?php echo $faq[0]->faq_id; ?>">Delete FAQ</a>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
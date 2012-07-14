<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<?php echo form_open('admin/update_partner_link');?>
		<fieldset>
			<h2>Edit Partner Links</h2>
			<label>Partner Link Text</label>
				<?php echo form_input('partner_link_text', set_value('partner_link_text', $partner_link[0]->partner_link_text)); ?>
				<?php echo form_error('partner_link_text'); ?>
				<br class="clear_float" />
			<label>Partner Link Text</label>
				<?php echo form_input('partner_link_url', set_value('partner_link_url', $partner_link[0]->partner_link_url)); ?>
				<?php echo form_error('partner_link_url'); ?>
				<br class="clear_float" />
		</fieldset>
		<?php echo form_hidden('partner_link_id', $partner_link[0]->partner_link_id); ?>
		<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
	<?php echo form_close(); ?>
	<a class="delete" href="<?php echo base_url(); ?>admin/delete_partner_link/<?php echo $partner_link[0]->partner_link_id; ?>">Delete Partner Link</a>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
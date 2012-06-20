<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2 article">
	<h1><?php echo $feed_module[0]->feed_module_name; ?></h1>
	<div class="feed_module_demo">
		<div class="feed_module"><?php echo $feed_module[0]->feed_module_code; ?></div>
		<h2>Embed Code</h2>
		<label>Copy this code and paste into your website code</label>
		<?php echo form_textarea('feed_module_code', set_value('feed_module_code', $feed_module[0]->feed_module_code)); ?>
	</div>
</div>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
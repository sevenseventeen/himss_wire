<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	
	<p>You are now logged out.</p>
		
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
<?php 
	$data['main_navigation'] = 'contact';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

			<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2">
				Contact Us
			</div>
			
			<br class="clear_float" />		

<?php 
	$this->content_library->load_footer();
?>
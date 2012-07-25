<?php
	$data['page_title'] = "HIMSSwire - Page Not Found";
	$data['main_navigation'] = '';
	$this->load->view('_includes/head', $data);
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2 page_not_found">
	<h1>Sorry, Page Not Found</h1>
	<p>Sorry, the page you requested was not found. Please choose from the navigation or search box above.</p>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
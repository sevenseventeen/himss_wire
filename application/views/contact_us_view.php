<?php 
	$data['main_navigation'] = 'contact';
	$data['page_title'] = "HIMSSwire -- How to Contact HIMSSwire";
	$this->load->view('_includes/head', $data);
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2 static_page">
	<?php echo $static_page_content[0]->content; ?>
</div>
<br class="clear_float" />	

<?php 
	$this->content_library->load_footer();
?>
<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h1><?php echo $article[0]->article_title; ?></h1>
	<?php echo $article[0]->publish_date; ?>
			*** Print | Share ***
	<br class="clear_float" />
	<?php echo $article[0]->article_body; ?>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
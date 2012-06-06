<?php 
	$data['main_navigation'] = 'articles';
	$data['category_name'] = $article[0]->category_name;
	$data['category_id'] = $article[0]->article_category_id;
	$data['article_title'] = $article[0]->article_title;
	$data['article_id'] = $article[0]->article_id;
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<?php //echo print_r($article); ?>

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
<?php 
	$data['main_navigation'] = 'articles';
	$data['category_name'] = $article[0]->category_name;
	$data['category_id'] = $article[0]->article_category_id;
	$data['article_title'] = $article[0]->article_title;
	$data['article_id'] = $article[0]->article_id;
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<?php 
	$date = new DateTime($article[0]->publish_date);
	$date_formatted = $date->format('m-d-Y');
?>

<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2 article">
	<h1><?php echo $article[0]->article_title; ?></h1>
	<div class="date"><?php echo $date_formatted; ?></div>
	<div class="addthis_toolbox addthis_default_style ">
		<a href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4fd2ae7257ffdec9" class="addthis_button_compact">Share</a>
	</div>
	<div id="print_share"> | <a href="#" onclick="window.print();">
		 Print</a> 
	</div>
	<?php echo $article[0]->article_body; ?>
</div>

<aside>
	<?php $this->load->view('_includes/search_module'); ?>
	<div id="related_articles" class="rounded_corners_10 module_300 inner_shadow_2">
		<h3 class="module_header_no_icon rounded_top_corners_10 header_gradient inner_shadow_2">Related Articles</h3>
		<?php 
			foreach ($related_articles as $related_article) {
				$date = new DateTime($related_article->publish_date);
				$date_formatted = $date->format('m-d-Y');
				echo "<a href='".base_url()."article/".$related_article->article_id."'><h4>".$related_article->article_title."<span class='date'>".$date_formatted."</span></h4></a>";	
			}
		?>
	</div>
	<?php $this->load->view('_includes/banner_ad_module'); ?>
</aside>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
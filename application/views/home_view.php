<?php 
	$data['main_navigation'] = 'home';
	$data['page_title'] = "HIMSSwire - News from the Healthcare IT Community";
	$this->load->view('_includes/head', $data);
	$this->load->view('_includes/header', $data);
?>

<div id="main_content">
	<div class="category_module module_600 rounded_corners_10 inner_shadow_2">
		<img class="module_header_icon" src="_images/latest_article_icon.png" />
		<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">Latest Headlines</h1>
		<?php foreach ($articles as $article) { ?>
			<div class="article_snippet">
				<h2><a href="<?php echo base_url().'article/'.$article->article_slug; ?>"><?php echo $article->article_title; ?></a></h2>
				<h3 class="date_and_category">
					<?php 
						$date = new DateTime($article->publish_date);
						echo $date->format('m-d-Y');
						echo " | <a href='".base_url().'category/'.$article->category_slug."'>".$article->category_name."</a>";
					?>
				</h3>
				<p><?php echo $article->article_summary; ?></p>
			</div>
		<?php }?>
	</div>
</div>

<aside>
	<?php $this->load->view('_includes/feature_module'); ?>
	<?php $this->load->view('_includes/feature_module_optional'); ?>
	<?php $this->load->view('_includes/banner_ad_module'); ?>
	<?php $this->load->view('_includes/partner_links_module', $data); ?>
</aside>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
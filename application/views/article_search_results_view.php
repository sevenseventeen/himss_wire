<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content">
		<div class="category_module module_450 rounded_corners_10 inner_shadow_2">
			<img class="module_header_icon" src="<?php echo base_url(); ?>_images/latest_article_icon.png" />
			<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">Search Results</h1>
			<?php if (count($search_results) > 0) { ?>
				<?php foreach ($search_results as $article) { ?>
					<div class="article_snippet">
						<h2><?php echo $article->article_title; ?></h2>
						<h3 class="date"><?php echo $article->publish_date; ?></h3>
						<br class=" clear_float" />
						<?php echo $article->article_summary; ?>
						<a href="<?php echo base_url().'article/'.$article->article_id; ?>" class="category">Read Article</a>
					</div>
				<?php } ?>		
			<?php } else { ?>
				<div class="article_snippet">
					<h2>No results found.</h2>
					<br class=" clear_float" />
					<p>Sorry, we did not find any articles matching that search term.</p>
				</div>
			<?php } ?>
		</div>
	</div>
	<br class="clear_float" />

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
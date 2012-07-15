<?php 
	$data['main_navigation'] = '';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content">
	<div class="category_module module_600 rounded_corners_10 inner_shadow_2">
		<img class="module_header_icon" src="<?php echo base_url(); ?>_images/latest_article_icon.png" />
		<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">Search Results</h1>
		<?php if (count($search_results) > 0) { ?>
			<?php foreach ($search_results as $article) { ?>
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
					<p><a href="<?php echo base_url().'article/'.$article->article_id; ?>">Read Article</a></p>
				</div>
			<?php } ?>		
		<?php } else { ?>
			<div>
				<h2>No results found.</h2>
				<p>Sorry, we did not find any articles matching that search term.</p>
			</div>
		<?php } ?>
	</div>
	
	<br class="clear_float" />
	<?php if($pagination_links != '') { ?>
		<div class="module_600 rounded_corners_10 inner_shadow_2">
			<div id="pagination"><?php echo $pagination_links; ?></div>		
		</div>
	<?php } ?> 
</div>

<aside>
	<?php $this->load->view('_includes/partner_links_module'); ?>
</aside>
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
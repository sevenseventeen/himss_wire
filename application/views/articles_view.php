<?php 
	$data['main_navigation'] = 'articles_home';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>
		
<div id="main_content">
	<?php foreach ($results as $key => $result) { ?>
		<?php if(count($result) > 0) { ?>
			<div class="category_module module_920 rounded_corners_10 inner_shadow_2">
				<img class="module_header_icon" src="_images/latest_article_icon.png" />
				<a href="<?php echo base_url().'category/'.$result[0]->category_slug; ?>">
					<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2"><?php echo $result[0]->category_name; ?></h1>
				</a>
				<?php foreach ($result as $key => $article) { ?>
					<div class="article_snippet">
						<h2><a href="<?php echo base_url().'article/'.$result[$key]->category_slug.'/'.$result[$key]->article_slug; ?>"><?php echo $result[$key]->article_title; ?></a></h2>
						<h3 class="date_and_category">
							<?php 
								$date = new DateTime($result[$key]->publish_date);
								echo $date->format('m-d-Y');
								echo " | <a href='".base_url().'category/'.$result[0]->category_slug."'>".$result[0]->category_name."</a>";
							?>
						</h3>
						<p><?php echo $result[$key]->article_summary; ?></p>
					</div>
				<?php }?>
			</div>
		<?php } ?>
	<?php } ?>
</div>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
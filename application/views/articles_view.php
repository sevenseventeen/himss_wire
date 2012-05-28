<?php 
	$data['main_navigation'] = 'contact';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>
		
			<div id="main_content">
				<?php foreach ($results as $key => $result) { ?>
					<?php if(count($result) > 0) { ?>
						<div class="category_module module_450 rounded_corners_10 inner_shadow_2">
							<img class="module_header_icon" src="_images/latest_article_icon.png" />
							<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2"><?php echo $result[0]->category_name; ?></h1>
							<a href="<?php echo base_url().'category/'.$result[0]->article_category_id; ?>" class="module_header_view_all">View Category</a>
							<?php foreach ($result as $key => $article) { ?>
								<div class="article_snippet">
									<h2><?php echo $result[$key]->article_title; ?></h2>
									<h3 class="date"><?php echo $result[$key]->publish_date; ?></h3>
									<br class=" clear_float" />
									<?php echo $result[$key]->article_summary; ?>
									<a href="<?php echo base_url().'article/'.$result[$key]->article_id; ?>" class="category">Read More</a>
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
<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>
	
	<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2">
		<img class="module_header_icon" src="_images/latest_article_icon.png" />
		<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">The Latest</h1>
		<?php foreach ($articles as $article) { ?>
			<div class="article_snippet">
				<h2><?php echo $article->article_title; ?></h2>
				<h3 class="date"><?php echo $article->publish_date; ?></h3>
				<br class=" clear_float" />
				<?php echo $article->article_summary; ?>
				<a href="<?php echo base_url().'article/'.$article->article_id; ?>" class="category">Read Article</a>
			</div>
		<?php }?>
	</div>
			
	<aside>
		<div id="feature" class="rounded_corners_10 module_300 inner_shadow_2">
			<h3 class="module_header_no_icon rounded_top_corners_10 header_gradient inner_shadow_2">Feature</h3>
			<p><?php echo $feature_module[0]->module_text; ?></p>
			<img src="_images/<?php echo $feature_module[0]->module_image; ?>" />
		</div>
		<div id="search_module" class="module_300 header_gradient rounded_corners_10 inner_shadow_2">
			<h3>Article Search</h3>
			<form>
				<input class="rounded_corners_10 inner_shadow_2" type="text" name="" value="" />
				<input type="submit" value="Search" class="article_search_button">
			</form>
		</div>
		<div id="linked_in_module" class="module_300 rounded_corners_10 inner_shadow_2">
			<h3>LinkedIn Connection</h3>
			<p>Check LinkedIn for feed</p>
		</div>
		<div class="module_300 rounded_corners_10 inner_shadow_2" id="banner_ad">
			<img src="_uploads/<?php echo $banner_ad[0]->banner_image_path; ?>" width="270"/>
		</div>
	</aside>
	
	<!--<script type="text/javascript" src="http://cdn.widgetserver.com/syndication/subscriber/InsertWidget.js"></script><script type="text/javascript">if (WIDGETBOX) WIDGETBOX.renderWidget('75f5638c-1d72-4f35-a0d7-f04f9a038da2');</script>
	<noscript>Get the <a href="http://www.widgetbox.com/widget/apple-hot-news-sevenseventeen">Apple Hot News</a> widget and many other <a href="http://www.widgetbox.com/">great free widgets</a> at <a href="http://www.widgetbox.com">Widgetbox</a>! Not seeing a widget? (<a href="http://support.widgetbox.com/">More info</a>)</noscript>
	-->
			
	<br class="clear_float" />
			

<?php 
	$this->content_library->load_footer();
?>